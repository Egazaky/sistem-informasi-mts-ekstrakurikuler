@extends('landing.layout')

@section('content')
<section class="berita-section fade-in-left" style="background: #f8f9fa; padding: 4rem 0; min-height: 60vh;">
    <div class="berita-container" style="max-width: 900px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); padding: 2.5rem 2rem;">
        <h2 style="color: #2d5a27; text-align: center; margin-bottom: 2rem;">Berita Terbaru</h2>
        <div class="berita-list">
            @forelse ($berita as $item)
            <div class="berita-item" style="margin-bottom: 2.5rem; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
                @if($item->image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                @endif
            
                <div style="padding: 1.5rem;">
                    <h4 style="color: #2d5a27; margin-bottom: 1rem;">
                        <a href="{{ route('landing-berita-show', $item->id) }}"
                           style="color: inherit; text-decoration: none; font-size: 1.25rem; font-weight: 600; line-height: 1.4;">
                            {{ $item->title }}
                        </a>
                    </h4>
                    <p style="color: #666; line-height: 1.6; margin-bottom: 1rem;">
                        {{ Str::limit(strip_tags($item->content), 150) }}
                    </p>
                    <div style="display: flex; align-items: center; color: #888;">
                        <i class="far fa-calendar-alt" style="margin-right: 0.5rem;"></i>
                        <span style="font-size: 0.9rem;">{{ $item->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center" style="padding: 2rem;">
                <img src="{{ asset('img/no-data.svg') }}" alt="No Data" style="width: 150px; margin-bottom: 1rem;">
                <p style="color: #666;">Belum ada berita yang dipublikasikan</p>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $berita->links() }}
        </div>
    </div>
</section>
@endsection
