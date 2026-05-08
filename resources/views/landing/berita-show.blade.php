@extends('landing.layout')

@section('content')
<section class="berita-section fade-in-left" style="background: #f8f9fa; padding: 4rem 0; min-height: 60vh;">
    <div class="berita-container" style="max-width: 900px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); padding: 2.5rem 2rem;">
        <nav aria-label="breadcrumb" style="margin-bottom: 1.5rem;">
            <ol class="breadcrumb" style="background: transparent; padding: 0;">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" style="color: #4a7c59; text-decoration: none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('landing-berita') }}" style="color: #4a7c59; text-decoration: none;">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
            </ol>
        </nav>

        <h2 style="color: #2d5a27; margin-bottom: 1.5rem; font-size: 2rem; line-height: 1.3;">{{ $berita->title }}</h2>
        
        <div class="meta-info" style="margin-bottom: 2rem; color: #666; display: flex; align-items: center; gap: 1rem;">
            <span><i class="far fa-calendar-alt"></i> {{ $berita->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
            <span><i class="far fa-clock"></i> {{ $berita->created_at->locale('id')->isoFormat('HH:mm') }} WIB</span>
        </div>

        @if($berita->image)
        <div style="margin-bottom: 2rem; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <img src="{{ asset('storage/' . $berita->image) }}" 
                 alt="{{ $berita->title }}" 
                 style="width: 100%; max-height: 500px; object-fit: cover;">
        </div>
        @endif

        <div class="berita-content" style="color: #444; line-height: 1.8; font-size: 1.1rem;">
            {!! $berita->content !!}
        </div>

        <div class="share-buttons" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee;">
            <h5 style="color: #2d5a27; margin-bottom: 1rem;">Bagikan Berita Ini:</h5>
            <div style="display: flex; gap: 1rem;">
                <a href="https://wa.me/?text={{ urlencode($berita->title . ' - ' . route('landing-berita-show', $berita->id)) }}" 
                   target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('landing-berita-show', $berita->id)) }}" 
                   target="_blank" class="btn btn-primary">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->title) }}&url={{ urlencode(route('landing-berita-show', $berita->id)) }}" 
                   target="_blank" class="btn btn-info">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
