@extends('landing.layout')

@section('content')
<section class="fade-in-left" style="background: #f8f9fa; padding: 4rem 0 3rem; min-height: 60vh;">
    <div class="berita-container" style="max-width: 1100px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); padding: 2.5rem 2rem;">
        {{-- TENTANG KAMI --}}
        <div style="margin-bottom: 3rem;">
            <h2 style="color: #2d5a27; text-align: center; margin-bottom: 2rem;">
                {{ $profile->about_title ?? 'Tentang Kami' }}
            </h2>

            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    @if(!empty($profile?->about_image))
                        <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                            <img src="{{ asset('storage/' . $profile->about_image) }}"
                                 alt="Tentang Kami"
                                 style="width: 100%; height: 280px; object-fit: cover;">
                        </div>
                    @endif
                </div>
                <div class="col-md-7">
                    <div style="color: #444; line-height: 1.8; font-size: 1rem; text-align: justify;">
                        {!! nl2br(e($profile->about_description ?? 'Belum ada deskripsi profil yang ditambahkan. Silakan isi dari menu Profil di dashboard admin.')) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- GALERI --}}
        <hr style="margin: 0 0 2.5rem; border-color: #eee;">

        <h3 style="color: #2d5a27; text-align: center; margin-bottom: 2rem;">Galeri</h3>

        <div class="berita-list">
            @forelse($galleries as $item)
                <div class="berita-item" style="margin-bottom: 2rem; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
                    @if($item->image_path)
                        <div style="max-height: 320px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $item->image_path) }}"
                                 alt="{{ $item->caption ?? 'Foto galeri' }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endif

                    @if($item->caption)
                        <div style="padding: 1rem 1.25rem;">
                            <p style="margin: 0; color: #555; font-size: 0.98rem;">
                                {{ $item->caption }}
                            </p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center" style="padding: 2rem;">
                    <p style="color: #666;">Belum ada foto galeri yang ditambahkan.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $galleries->links() }}
        </div>

        {{-- RUBRIK GURU --}}
        @if(!empty($gurus) && $gurus->count() > 0)
            <hr style="margin: 3rem 0 2.5rem; border-color: #eee;">

            <h3 style="color: #2d5a27; text-align: center; margin-bottom: 2rem;">Rubrik Guru</h3>

            <div class="row g-4">
                @foreach($gurus as $guru)
                    <div class="col-md-6 col-lg-4">
                        <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%;"
                             onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'"
                             onmouseout="this.style.boxShadow='0 2px 15px rgba(0,0,0,0.05)'">

                            @if($guru->foto)
                                <div style="max-height: 250px; overflow: hidden; background: #f0f0f0;">
                                    <img src="{{ asset('storage/' . $guru->foto) }}"
                                         alt="{{ $guru->nama }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div style="max-height: 250px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="mdi mdi-account" style="font-size: 80px; color: #ccc;"></i>
                                </div>
                            @endif

                            <div style="padding: 1.5rem;">
                                <h5 style="margin: 0 0 0.5rem; color: #2d5a27; font-weight: 600;">
                                    {{ $guru->nama }}
                                </h5>

                                @if($guru->jabatan)
                                    <p style="margin: 0 0 1rem; color: #666; font-size: 0.9rem; font-style: italic;">
                                        {{ $guru->jabatan }}
                                    </p>
                                @endif

                                @if($guru->deskripsi)
                                    <p style="margin: 0; color: #555; font-size: 0.95rem; line-height: 1.6; text-align: justify;">
                                        {{ nl2br(e($guru->deskripsi)) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection



