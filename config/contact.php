<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nomor WhatsApp Admin / Tata Usaha
    |--------------------------------------------------------------------------
    |
    | Digunakan oleh tombol "Registrasi" di halaman login. Siswa tidak dapat
    | mendaftar sendiri — akun dibuat oleh admin — sehingga tombol ini
    | mengarahkan calon pengguna untuk menghubungi admin via WhatsApp.
    |
    | Format internasional tanpa tanda "+" atau spasi, contoh: 6281234567890.
    |
    */

    'whatsapp' => env('ADMIN_WHATSAPP', '6281234567890'),

];
