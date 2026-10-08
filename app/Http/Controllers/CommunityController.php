<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bonsai;
use App\Models\User;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\CommunityReaction;
use App\Models\CommunityPoll;
use App\Models\CommunityPollVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CommunityController extends Controller
{
    /**
     * Tampilkan halaman utama Komunitas BonsaiKu
     */
    public function index(Request $request)
    {
        // 1. Seed sample data jika database masih kosong
        $this->seedInitialDataIfEmpty();

        // 2. Query data postingan dengan filter & sort
        $query = CommunityPost::with(['user', 'bonsai', 'comments.user', 'poll', 'reactions']);

        // Filter Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter Spesies
        if ($request->filled('species') && $request->species !== 'Semua') {
            $query->where('species', $request->species);
        }

        // Urutan / Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $query->orderByRaw('(subur_count + likes_count) DESC');
        } elseif ($sort === 'solved') {
            $query->whereHas('comments', function ($q) {
                $q->where('is_best_solution', true);
            })->latest();
        } else {
            $query->latest();
        }

        $posts = $query->paginate(15);

        // 3. Produk bonsai aktif untuk sidebar rekomendasi dan modal pemilihan produk
        $featuredProducts = Bonsai::where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $allActiveBonsais = Bonsai::where('is_active', true)->select('id', 'name', 'current_value', 'image_path')->get();

        // 4. Data Sorotan / Story Pekan Ini (Bonsai of the Week)
        $spotlights = [
            [
                'author' => 'Khadir Florist',
                'role' => 'admin',
                'title' => 'Santigi Karang',
                'badge' => 'Pilihan Kurator',
                'image' => asset('images/bghero.png'),
                'avatar' => asset('images/logonobg.png'),
            ],
            [
                'author' => 'Hendra W.',
                'role' => 'user',
                'title' => 'Cemara Udang 3Th',
                'badge' => 'Juara Mingguan 🥇',
                'image' => asset('images/a.png'),
                'avatar' => null,
            ],
            [
                'author' => 'Dewi Kartika',
                'role' => 'user',
                'title' => 'Sancang On Rock',
                'badge' => 'Paling Subur 🌿',
                'image' => asset('images/bgkategori.png'),
                'avatar' => null,
            ],
            [
                'author' => 'Ahmad Fauzi',
                'role' => 'user',
                'title' => 'Kimeng Mini',
                'badge' => 'Tunas Baru 🌱',
                'image' => asset('images/b.jpg'),
                'avatar' => null,
            ],
        ];

        // 5. Spesies Bonsai untuk Filter Chips
        $speciesList = [
            'Semua',
            'Santigi Karang',
            'Beringin Kimeng',
            'Cemara Udang',
            'Anting Putri',
            'Sancang',
            'Asam Jawa',
        ];

        return view('shop.komunitas', compact(
            'posts',
            'featuredProducts',
            'allActiveBonsais',
            'spotlights',
            'speciesList'
        ));
    }

    /**
     * Simpan postingan baru dari pengguna atau admin toko
     */
    public function storePost(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk memposting.');
        }

        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        $request->validate([
            'content' => 'required|string|max:5000',
            'category' => 'required|string|in:diskusi,showcase,poll,promosi',
            'species' => 'nullable|string|max:100',
            'post_type' => 'nullable|string|in:standard,before_after,poll,flash_sale',
            'images.*' => 'nullable|image|max:10240', // Max 10MB per foto
            'before_image' => 'nullable|image|max:10240',
            'after_image' => 'nullable|image|max:10240',
            'bonsai_id' => 'nullable|exists:bonsais,id',
            'discount_code' => 'nullable|string|max:30',
            'discount_percent' => 'nullable|string|max:10',
            'flash_sale_hours' => 'nullable|integer|min:1|max:72',
            'poll_question' => 'nullable|string|max:255',
            'poll_option_a' => 'nullable|string|max:100',
            'poll_option_b' => 'nullable|string|max:100',
        ]);

        $category = $request->category;
        // Penegasan aturan: HANYA TOKO (ADMIN) YANG BISA MEMILIH KATEGORI PROMOSI
        if ($category === 'promosi' && !$isAdmin) {
            $category = 'diskusi';
        }

        $postType = $request->post_type ?? 'standard';
        if ($postType === 'flash_sale' && !$isAdmin) {
            $postType = 'standard';
        }

        // Handle upload foto-foto standar
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('community/posts', 'public');
                $imagePaths[] = 'storage/' . $path;
            }
        }

        // Handle upload Before-After
        $beforePath = null;
        $afterPath = null;
        if ($request->hasFile('before_image')) {
            $beforePath = 'storage/' . $request->file('before_image')->store('community/before_after', 'public');
        }
        if ($request->hasFile('after_image')) {
            $afterPath = 'storage/' . $request->file('after_image')->store('community/before_after', 'public');
        }

        // Flash sale timer
        $flashSaleEndsAt = null;
        if ($postType === 'flash_sale' && $request->filled('flash_sale_hours')) {
            $flashSaleEndsAt = Carbon::now()->addHours((int)$request->flash_sale_hours);
        }

        $post = CommunityPost::create([
            'user_id' => $user->id,
            'category' => $category,
            'species' => $request->species ?: 'Lainnya',
            'post_type' => $postType,
            'content' => $request->content,
            'images' => !empty($imagePaths) ? $imagePaths : null,
            'before_image' => $beforePath,
            'after_image' => $afterPath,
            'bonsai_id' => $isAdmin ? $request->bonsai_id : null,
            'discount_code' => $isAdmin ? $request->discount_code : null,
            'discount_percent' => $isAdmin ? $request->discount_percent : null,
            'flash_sale_ends_at' => $flashSaleEndsAt,
        ]);

        // Jika tipe poling, buat data poling
        if ($postType === 'poll' && $request->filled('poll_question')) {
            $options = [
                ['id' => 'a', 'text' => $request->poll_option_a ?: 'Pilihan A', 'votes' => 0],
                ['id' => 'b', 'text' => $request->poll_option_b ?: 'Pilihan B', 'votes' => 0],
            ];

            CommunityPoll::create([
                'post_id' => $post->id,
                'question' => $request->poll_question,
                'options' => $options,
                'total_votes' => 0,
            ]);
        }

        return redirect()->route('shop.komunitas')->with('success', 'Postingan Anda berhasil diterbitkan di komunitas! 🌿');
    }

    /**
     * Hapus postingan (oleh pemilik atau admin)
     */
    public function destroyPost($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $post = CommunityPost::findOrFail($id);

        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak memiliki izin menghapus postingan ini.');
        }

        $post->delete();

        return redirect()->route('shop.komunitas')->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * Toggle Reaksi (🌿 Subur / ❤️ Suka) via AJAX
     */
    public function toggleReaction(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu untuk memberikan reaksi.',
                'require_login' => true,
            ], 401);
        }

        $request->validate([
            'type' => 'required|in:subur,like',
        ]);

        $post = CommunityPost::findOrFail($id);
        $userId = Auth::id();
        $type = $request->type;

        $existing = CommunityReaction::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->where('type', $type)
            ->first();

        if ($existing) {
            $existing->delete();
            if ($type === 'subur') {
                $post->decrement('subur_count');
            } else {
                $post->decrement('likes_count');
            }
            $active = false;
        } else {
            CommunityReaction::create([
                'post_id' => $post->id,
                'user_id' => $userId,
                'type' => $type,
            ]);
            if ($type === 'subur') {
                $post->increment('subur_count');
            } else {
                $post->increment('likes_count');
            }
            $active = true;
        }

        $post->refresh();

        return response()->json([
            'success' => true,
            'active' => $active,
            'subur_count' => $post->subur_count,
            'likes_count' => $post->likes_count,
        ]);
    }

    /**
     * Kirim komentar pada postingan
     */
    public function storeComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan masuk untuk menulis komentar.');
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $post = CommunityPost::findOrFail($id);

        CommunityComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'is_best_solution' => false,
        ]);

        $post->increment('comments_count');

        return back()->with('success', 'Tanggapan Anda berhasil dikirim.');
    }

    /**
     * Tandai komentar sebagai Solusi Terverifikasi / Jawaban Terbaik
     */
    public function toggleBestSolution(Request $request, $commentId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $comment = CommunityComment::with('post')->findOrFail($commentId);
        $user = Auth::user();

        // Hanya pemilik postingan atau admin yang berhak menandai solusi terbaik
        if ($user->id !== $comment->post->user_id && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pembuat postingan atau tim toko yang dapat menandai solusi.',
            ], 403);
        }

        $newState = !$comment->is_best_solution;

        // Reset solusi terbaik lain di postingan yang sama jika ditandai baru
        if ($newState) {
            CommunityComment::where('post_id', $comment->post_id)->update(['is_best_solution' => false]);
        }

        $comment->is_best_solution = $newState;
        $comment->save();

        return response()->json([
            'success' => true,
            'is_best_solution' => $comment->is_best_solution,
            'message' => $comment->is_best_solution ? 'Komentar ditandai sebagai Solusi Terverifikasi! 🏆' : 'Tanda solusi dibatalkan.',
        ]);
    }

    /**
     * Berikan suara pada poling
     */
    public function votePoll(Request $request, $pollId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masuk untuk memberikan suara pada poling.',
                'require_login' => true,
            ], 401);
        }

        $request->validate([
            'option_id' => 'required|string',
        ]);

        $poll = CommunityPoll::findOrFail($pollId);
        $userId = Auth::id();

        // Cek apakah sudah pernah vote
        $existingVote = CommunityPollVote::where('post_id', $poll->post_id)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan suara pada poling ini.',
            ], 400);
        }

        CommunityPollVote::create([
            'post_id' => $poll->post_id,
            'user_id' => $userId,
            'option_id' => $request->option_id,
        ]);

        // Update vote count pada options
        $options = $poll->options;
        foreach ($options as &$opt) {
            if ($opt['id'] === $request->option_id) {
                $opt['votes'] = ($opt['votes'] ?? 0) + 1;
            }
        }
        $poll->options = $options;
        $poll->increment('total_votes');
        $poll->save();

        // Hitung ulang persentase
        $total = $poll->total_votes;
        $calculatedOptions = array_map(function ($opt) use ($total) {
            $percent = $total > 0 ? round(($opt['votes'] / $total) * 100) : 0;
            return [
                'id' => $opt['id'],
                'text' => $opt['text'],
                'votes' => $opt['votes'],
                'percent' => $percent,
            ];
        }, $poll->options);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, suara Anda telah dicatat! ✨',
            'options' => $calculatedOptions,
            'total_votes' => $total,
            'voted_option' => $request->option_id,
        ]);
    }

    /**
     * Helper Seed data jika database masih kosong
     */
    private function seedInitialDataIfEmpty()
    {
        if (CommunityPost::count() > 0) {
            return;
        }

        $admin = User::where('role', 'admin')->first() ?: User::first();
        $regularUser = User::where('role', 'user')->first() ?: $admin;
        $otherUser = User::where('id', '!=', $admin->id)->first() ?: $admin;
        $featuredProduct = Bonsai::where('is_active', true)->first();

        if (!$admin) return;

        // 1. Post Flash Sale (Toko Resmi)
        $post1 = CommunityPost::create([
            'user_id' => $admin->id,
            'category' => 'promosi',
            'species' => 'Santigi Karang',
            'post_type' => 'flash_sale',
            'content' => "🌿 FLASH DEAL KHUSUS MEMBER KOMUNITAS! 🌿\n\nUntuk menyambut awal bulan, Khadir Florist membuka penawaran spesial untuk Bonsai Santigi Karang (Pemphis Acidula) usia budidaya 6 tahun. Batang terpilin alami, perakaran mencengkeram batu karang laut, dan kondisi sangat prima siap pajang.\n\nGunakan kode voucher **KOMUNITAS10** saat checkout untuk potongan langsung 10% dan gratis packing kayu khusus. Stok hanya 2 unit minggu ini!",
            'images' => [asset('images/bghero.png')],
            'bonsai_id' => $featuredProduct ? $featuredProduct->id : null,
            'discount_code' => 'KOMUNITAS10',
            'discount_percent' => '10%',
            'flash_sale_ends_at' => Carbon::now()->addHours(6),
            'likes_count' => 58,
            'subur_count' => 42,
            'comments_count' => 2,
        ]);

        CommunityComment::create([
            'post_id' => $post1->id,
            'user_id' => $regularUser->id,
            'comment' => 'Bisa COD atau langsung cek ke kebun florist-nya gak min?',
            'is_best_solution' => false,
        ]);

        CommunityComment::create([
            'post_id' => $post1->id,
            'user_id' => $admin->id,
            'comment' => 'Halo Kak, sangat bisa! Kunjungi galeri kebun kami di Medan atau bisa order via web dengan proteksi garansi sampai.',
            'is_best_solution' => false,
        ]);

        // 2. Post Before vs After
        CommunityPost::create([
            'user_id' => $otherUser->id,
            'category' => 'showcase',
            'species' => 'Cemara Udang',
            'post_type' => 'before_after',
            'content' => "Geser slider untuk melihat progres 3 tahun transformasi Cemara Udang! 🔄\n\nDari bahan bakalan polos hasil berburu tahun 2023, perlahan diarahkan gaya Formal Tegak (Chokkan) dengan pemangkasan berkala dan kawat aluminium 3mm. Kuncinya sabar dan jangan terburu-buru ganti pot.",
            'before_image' => asset('images/b.jpg'),
            'after_image' => asset('images/a.png'),
            'likes_count' => 96,
            'subur_count' => 74,
            'comments_count' => 0,
        ]);

        // 3. Post Q&A dengan Solusi Terverifikasi
        $post3 = CommunityPost::create([
            'user_id' => $regularUser->id,
            'category' => 'diskusi',
            'species' => 'Beringin Kimeng',
            'post_type' => 'standard',
            'content' => "Mohon bantuan solusinya sesepuh dan dokter tanaman Khadir Florist 🙏\n\nBeringin kimeng saya 4 hari lalu ganti media tanam (pasir malang + sekam bakar). Namun daun di bagian ujung pucuk mulai menguning dan ada yang layu. Apakah ini stres akar biasa atau perlu penanganan khusus ya?",
            'images' => [asset('images/bglogin.webp')],
            'likes_count' => 24,
            'subur_count' => 12,
            'comments_count' => 1,
        ]);

        CommunityComment::create([
            'post_id' => $post3->id,
            'user_id' => $admin->id,
            'comment' => 'Halo Kak! Ini gejala klasik "Root Shock" (stres adaptasi akar). Solusinya: 1) Segera pindahkan ke tempat teduh tanpa sinar matahari siang langsung selama 10 hari. 2) Siram vitamin B1 cair seminggu 2x untuk perangsang akar halus. 3) Jangan beri pupuk kimia dulu sampai muncul kuncup tunas baru hijau segar.',
            'is_best_solution' => true,
        ]);

        // 4. Post Poling Desain Cabang
        $post4 = CommunityPost::create([
            'user_id' => $otherUser->id,
            'category' => 'poll',
            'species' => 'Sancang',
            'post_type' => 'poll',
            'content' => "Butuh saran pandangan estetika dari teman-teman komunitas!\n\nLagi proses wiring bahan Sancang mini ini. Karakter batangnya agak melengkung tajam di bagian bawah. Enaknya diarahkan ke Kengai atau Moyogi ya? Bantu vote di bawah ya kawan-kawan 👇",
            'images' => [asset('images/c.jpg')],
            'likes_count' => 45,
            'subur_count' => 30,
            'comments_count' => 0,
        ]);

        CommunityPoll::create([
            'post_id' => $post4->id,
            'question' => 'Menurut kalian, bakalan bahan Sancang ini lebih cocok diarahkan ke gaya apa?',
            'options' => [
                ['id' => 'a', 'text' => 'Gaya Kengai (Menggantung Air Terjun)', 'votes' => 46],
                ['id' => 'b', 'text' => 'Gaya Moyogi (Tegak Berkelok Alami)', 'votes' => 22],
            ],
            'total_votes' => 68,
        ]);
    }
}
