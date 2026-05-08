<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <div class="mb-2">
            <strong>{{ optional($homeSetting)->judul_utama ?? 'MTS AL-ISLAM JEPARA' }}</strong><br>
            {{ optional($homeSetting)->alamat ?? 'Jl. Raya Jepara' }}<br>
            {{ optional($homeSetting)->telepon ?? '(0431) 123456' }}<br>
            {{ optional($homeSetting)->email ?? 'info@mtsalislam.sch.id' }}
        </div>
        <div class="small">
            © {{ now()->year }} {{ optional($homeSetting)->footer ?? 'MTS AL-ISLAM JEPARA. All rights reserved.' }}
        </div>
    </div>
</footer>
