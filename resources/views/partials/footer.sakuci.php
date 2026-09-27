<footer class="border-top bg-body py-4 mt-2">
    <div class="container">
        <div class="row gy-3 align-items-center justify-content-between text-center text-md-start">
            
            {{-- Kolom Kiri: Penjelasan UKK & Fitur Keanggotaan --}}
            <div class="col-md-7">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                    <span class="badge bg-brand-subtle text-white fw-semibold px-2 py-1" style="font-size: 0.75rem;">P-UKK</span>
                    <h6 class="fw-bold mb-0">Nexus Digital Library</h6>
                </div>
                
                {{-- Catchphrase dari Sidebar --}}
                <div class="text-brand fw-semibold small mb-1">
                    Akselerasi Literasi, Memicu Energi Vokasi
                </div>

                {{-- Deskripsi Pengembangan Peminjaman & Keanggotaan --}}
                <p class="text-secondary small mb-0" style="max-width: 540px;">
                    Pengembangan sistem <strong>Peminjaman Buku</strong> perpustakaan digital berbasis verifikasi <strong>Keanggotaan</strong>.
                    Siswa wajib terdaftar dan diverifikasi sebagai anggota aktif sebelum dapat melakukan pengajuan peminjaman buku.
                </p>
            </div>

            {{-- Kolom Kanan: Ikon Sosial Media & Website --}}
            <div class="col-md-4 text-md-end">
                <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-3 mb-2">
                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/rirriiessa_/?utm_source=ig_web_button_share_sheet" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                       style="width: 36px; height: 36px;" title="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>

                    {{-- GitHub --}}
                    <a href="https://github.com/ericaaleysa" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                       style="width: 36px; height: 36px;" title="GitHub">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                        </svg>
                    </a>

                    <a href="https://smksangkuriang1cimahi.sch.id" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                       style="width: 36px; height: 36px;" title="Website Sekolah">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-3 opacity-25">

        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-between text-center text-md-start text-secondary small gap-2">
            <div>
                <div>&copy; {{ date('Y') }} Nexus Digital Library.</div>
                <div>Developed by Erica Aleysa Putri | All rights reserved.</div>
            </div>
            <div class="opacity-75">
                Sakuci Framework - Created by Indra Batara, S.Pd., Gr.
            </div>
        </div>
    </div>
</footer>