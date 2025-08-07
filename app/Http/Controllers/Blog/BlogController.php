<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs for dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */

    public function index(Request $request): \Inertia\Response
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10);

        // Her blog için featured_image alanını tam url'ye çevir
        $blogs->getCollection()->transform(function ($blog) {
            if ($blog->featured_image) {
                $blog->featured_image = asset('storage/' . $blog->featured_image);
            }
            return $blog;
        });

        return Inertia::render('blogs/index', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        // Inertia.js ile 'blogs/create' Vue componentini render et
        return Inertia::render('blogs/create');
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Gelen isteği doğrula
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'content_type' => 'required|in:tiptap,html',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Zorunlu!
            'featured_image_alt' => 'required|string|max:255',
            'published_at' => 'required|date',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'meta_keywords' => 'required|string|max:255',
            'canonical_url' => 'required|string|max:255',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);

        // Resim olmadan işlem gerçekleşmez, burada zaten required!
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blog/featured', 'public');
            $validatedData['featured_image'] = $imagePath; // Sadece dosya yolu kaydedilir
        } else {
            // Bu else bloğu aslında çalışmaz çünkü validation'da required!
            return back()->withErrors(['featured_image' => 'Resim yüklenmesi zorunludur.']);
        }

        Blog::create($validatedData);

        return redirect()->route('blogs.index')->with('success', 'Blog yazısı başarıyla oluşturuldu.');
    }

    /**
     * Display the specified blog for dashboard.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Inertia\Response
     */
    public function show(Blog $blog): \Inertia\Response
    {
        // Öne çıkan görseli tam url olarak ekle
        if ($blog->featured_image) {
            $blog->featured_image = asset('storage/' . $blog->featured_image);
        }

        return Inertia::render('blogs/show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Inertia\Response
     */
    public function edit(Blog $blog): \Inertia\Response
    {
        return Inertia::render('blogs/edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Update the specified blog in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Blog $blog): \Illuminate\Http\RedirectResponse
    {
        // Gelen isteği doğrula - görsel alanları kaldırıldı
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string', // HTML içeriği için uzunluk kısıtlaması olmadan
            'content_type' => 'required|in:tiptap,html', // İçerik tipi
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        // Başlık değiştiyse slug'ı güncelle
        if (isset($validatedData['title'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
        }

        // HTML içeriği ise güvenlik kontrolü yap (isteğe bağlı)
        if ($validatedData['content_type'] === 'html') {
            // HTML içeriğini temizle veya doğrula (isteğe bağlı)
            // $validatedData['content'] = $this->sanitizeHtml($validatedData['content']);
        }

        // Blogu güncelle - görsel alanları güncellenmez
        $blog->update($validatedData);

        // Başarılı mesajıyla blog listeleme sayfasına yönlendir
        return redirect()->route('blogs.index')->with('success', 'Blog yazısı başarıyla güncellendi.');
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Blog $blog): \Illuminate\Http\RedirectResponse
    {
        // Öne çıkan görseli varsa sil
        if ($blog->featured_image) {
            $imagePath = str_replace('/storage', 'public', $blog->featured_image);
            Storage::delete($imagePath);
        }

        // Blogu sil
        $blog->delete();

        // Başarılı mesajıyla blog listeleme sayfasına yönlendir
        return redirect()->route('blogs.index')->with('success', 'Blog yazısı başarıyla silindi.');
    }

    /**
     * Show the form for editing the blog's featured image.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Inertia\Response
     */
    public function editImage(Blog $blog): \Inertia\Response
    {
        // Görsel varsa tam url ekle
        if ($blog->featured_image) {
            $blog->featured_image = asset('storage/' . $blog->featured_image);
        }

        return Inertia::render('blogs/edit-image', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the blog's featured image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_alt' => 'required|string|max:255',
        ]);

        // Eğer yeni görsel geldiyse
        if ($request->hasFile('featured_image')) {
            // Eski görseli sil
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            // Yeni görseli yükle
            $imagePath = $request->file('featured_image')->store('blog/featured', 'public');
            $validatedData['featured_image'] = $imagePath;
        }

        // Alt bilgisini güncelle
        $blog->update([
            'featured_image' => $validatedData['featured_image'] ?? $blog->featured_image,
            'featured_image_alt' => $validatedData['featured_image_alt'],
        ]);

        return redirect()->route('blogs.show', $blog)->with('success', 'Öne çıkan görsel başarıyla güncellendi.');
    }


    /**
     * Upload an image for the blog content editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store image in 'public' disk so it's accessible via /storage
        $imagePath = $request->file('image')->store('blog/content', 'public');
        $url = Storage::url($imagePath);

        return response()->json([
            'url' => $url
        ]);
    }

    /**
     * Delete an image from the blog content editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $url = $request->input('url');
        $path = str_replace('/storage', 'public', $url);

        if (Storage::exists($path) && Str::startsWith($path, 'public/blog/content/')) {
            Storage::delete($path);
            return response()->json(['success' => true, 'message' => 'Görsel başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Görsel bulunamadı veya silinemedi.'], 404);
    }

    /**
     * HTML içeriğini temizle (isteğe bağlı güvenlik fonksiyonu)
     *
     * @param string $html
     * @return string
     */
    private function sanitizeHtml(string $html): string
    {
        // HTML Purifier veya benzer bir kütüphane kullanabilirsiniz
        // Şimdilik basit bir temizleme
        return $html;
    }
}
