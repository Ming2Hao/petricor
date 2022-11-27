<?php
    require_once("connection.php");
    if(isset($_POST['passing'])){
        $_SESSION['emailPassing'] = $_POST['passingEmail'];
        header('Location: register.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <style>
        @media screen and (min-device-width: 300px) and (max-device-width: 500px) { 
            .kartu{
               height: 200px;
            }

            .gambar{
                display: none;
            }

            .hp{
                display: block;
            }

        }
        @media screen and (min-device-width: 600px) and (max-device-width: 950px) { 
            .kartu{
               height: 200px;
            }

            .gambar{
                display: none;
            }

            .hp{
                display: block;
            }

        }
        @media screen and (min-width:1000px){
            .kartu{
                height: 500px;
            }
            .hp{
                display: none;
            }
        }

        html, body{
            width: 100%;
        }

        form .form-field{
            margin-bottom:40px;
            width: 100%;
            position: relative;
        }

        form .form-field label{
            position: absolute;
            left:0;
            top:12px;
            color:#ffff;
            transition: all .5s ease;
            pointer-events: none; 
        }

        form .form-field.active label{
            color:#ffff;
            top:-25px;
        }

        form .form-field .border-line{
            position: absolute;
            left:0;
            bottom:0;
            width:0;
            height:2px;
            background-color:#3F4441;
            transition: all .5s ease;	
        }
        
        form .form-field.active .border-line{
            width:100%;
        }
        
        form .form-field input{
            height:40px;
            color:#ffff;
            width: 100%;
            background-color: transparent;
            border:none;
            border-bottom:1px solid #3F4441;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
    <div class="container-fluid px-0">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid d-flex">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
            </a>
            <div class="d-lg-flex justify-content-end d-sm-block">
                <a href="catalogue.php" class="link-light mt-4 ms-0 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">KATALOG</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="contactUsBelumLogin.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
            </div>
        </div>
        </nav>

        <div class="pt-2 ps-3 col-lg-10 col-12">
            <h2 class="fw-bold">Syarat dan Ketentuan</h2>
            <p>Syarat dan ketentuan ini (&#8220;Perjanjian&#8221;) menetapkan syarat dan ketentuan umum penggunaan Anda atas situs web <a href="https://erefiv.com">erefiv.com</a> (&#8220;Situs Web&#8221; atau &#8220;Layanan&#8221;) dan salah satu produk dan layanan terkaitnya (secara kolektif, &#8220;Layanan&#8221;). Perjanjian ini mengikat secara hukum antara Anda (&#8220;Pengguna&#8221;, &#8220;Anda&#8221; atau &#8220;Anda&#8221;) dan operator Situs Web ini (&#8220;Operator&#8221;, &#8220;kita&#8221;, &#8220;kita&#8221; atau &#8220;milik kita&#8221;). Jika Anda menyepakati perjanjian ini atas nama bisnis atau badan hukum lainnya, Anda menyatakan bahwa Anda memiliki wewenang untuk mengikat entitas tersebut ke perjanjian ini, dalam hal ini istilah &#8220;Pengguna&#8221;, &#8220; kamu&#8221; atau &#8220;Anda&#8221; mengacu pada entitas tersebut. Jika Anda tidak memiliki wewenang tersebut, atau jika Anda tidak setuju dengan ketentuan perjanjian ini, Anda tidak boleh menerima perjanjian ini dan tidak boleh mengakses dan menggunakan Situs Web dan Layanan. Dengan mengakses dan menggunakan Situs Web dan Layanan, Anda mengakui bahwa Anda telah membaca, memahami, dan setuju untuk terikat dengan ketentuan Perjanjian ini. Anda mengakui bahwa Perjanjian ini adalah kontrak antara Anda dan Operator, meskipun bersifat elektronik dan tidak ditandatangani secara fisik oleh Anda, dan mengatur penggunaan Anda atas Situs Web dan Layanan.</p>
            <!-- <h4 class="fw-bold">Table of contents</h4>
            <ol class="wpembed-index">
                <li><a href="#accounts-and-membership">Accounts and membership</a></li>
                <li><a href="#links-to-other-resources">Links to other resources</a></li><li><a href="#prohibited-uses">Prohibited uses</a></li>
                <li><a href="#intellectual-property-rights">Intellectual property rights</a></li><li><a href="#limitation-of-liability">Limitation of liability</a></li><li><a href="#indemnification">Indemnification</a></li>
                <li><a href="#severability">Severability</a></li><li><a href="#dispute-resolution">Dispute resolution</a></li>
                <li><a href="#changes-and-amendments">Changes and amendments</a></li><li><a href="#acceptance-of-these-terms">Acceptance of these terms</a></li><li><a href="#contacting-us">Contacting us</a></li>
            </ol> -->
            <h5 id="accounts-and-membership" class="fw-bold">Akun dan keanggotaan</h5>
            <p>Anda harus berusia minimal 16 tahun untuk menggunakan Situs Web dan Layanan. Dengan menggunakan Situs Web dan Layanan dan dengan menyetujui Perjanjian ini, Anda menjamin dan menyatakan bahwa Anda berusia minimal 16 tahun.</p>
            <p>Jika Anda membuat akun di Situs Web, Anda bertanggung jawab untuk menjaga keamanan akun Anda dan Anda bertanggung jawab penuh atas semua aktivitas yang terjadi di bawah akun tersebut dan tindakan lain yang diambil sehubungan dengannya. Kami mungkin, tetapi tidak berkewajiban untuk, memantau dan meninjau akun baru sebelum Anda masuk dan mulai menggunakan Layanan. Memberikan informasi kontak palsu dalam bentuk apa pun dapat mengakibatkan penghentian akun Anda. Anda harus segera memberi tahu kami tentang penggunaan akun Anda yang tidak sah atau pelanggaran keamanan lainnya. Kami tidak akan bertanggung jawab atas tindakan atau kelalaian apa pun oleh Anda, termasuk kerugian apa pun yang timbul sebagai akibat dari tindakan atau kelalaian tersebut. Kami dapat menangguhkan, menonaktifkan, atau menghapus akun Anda (atau bagian mana pun darinya) jika kami memutuskan bahwa Anda telah melanggar ketentuan mana pun dari Perjanjian ini atau bahwa perilaku atau konten Anda cenderung merusak reputasi dan niat baik kami. Jika kami menghapus akun Anda karena alasan di atas, Anda tidak dapat mendaftar ulang untuk Layanan kami. Kami dapat memblokir alamat email dan alamat protokol Internet Anda untuk mencegah pendaftaran lebih lanjut.</p>
            <h5 id="links-to-other-resources" class="fw-bold">Tautan ke sumber daya lain</h5>
            <p>Meskipun Situs Web dan Layanan dapat menautkan ke sumber daya lain (seperti situs web, aplikasi seluler, dll.), kami tidak, secara langsung atau tidak langsung, menyiratkan persetujuan, asosiasi, sponsor, dukungan, atau afiliasi apa pun dengan sumber daya tertaut apa pun, kecuali dinyatakan secara khusus disini. Kami tidak bertanggung jawab untuk memeriksa atau mengevaluasi, dan kami tidak menjamin penawaran dari, bisnis atau individu mana pun atau konten dari sumber daya mereka. Kami tidak bertanggung jawab atau berkewajiban atas tindakan, produk, layanan, dan konten dari pihak ketiga lainnya. Anda harus dengan hati-hati meninjau pernyataan hukum dan ketentuan lain penggunaan sumber daya apa pun yang Anda akses melalui tautan di Situs Web. Tautan Anda ke sumber daya di luar situs lainnya adalah risiko Anda sendiri.</p>
            <h5 id="prohibited-uses" class="fw-bold">Penggunaan yang dilarang</h5>
            <p>Selain ketentuan lain sebagaimana diatur dalam Perjanjian, Anda dilarang menggunakan Situs Web dan Layanan atau Konten: (a) untuk tujuan yang melanggar hukum; (b) meminta orang lain untuk melakukan atau berpartisipasi dalam tindakan yang melanggar hukum; (c) untuk melanggar peraturan internasional, federal, provinsi atau negara bagian, peraturan, undang-undang, atau peraturan daerah; (d) melanggar atau menyalahi hak kekayaan intelektual kami atau hak kekayaan intelektual orang lain; (e) untuk melecehkan, menyalahgunakan, menghina, merugikan, mencemarkan nama baik, memfitnah, meremehkan, mengintimidasi, atau mendiskriminasi berdasarkan jenis kelamin, orientasi seksual, agama, etnis, ras, usia, asal kebangsaan, atau kecacatan; (f) untuk mengirimkan informasi yang salah atau menyesatkan; (g) untuk mengunggah atau mengirimkan virus atau jenis kode jahat lainnya yang akan atau mungkin digunakan dengan cara apa pun yang akan memengaruhi fungsionalitas atau pengoperasian Situs Web dan Layanan, produk dan layanan pihak ketiga, atau Internet; (h) untuk spam, phish, pharm, dalih, spider, crawl, atau scrape; (i) untuk tujuan cabul atau tidak bermoral; atau (j) mengganggu atau mengakali fitur keamanan Situs Web dan Layanan, produk dan layanan pihak ketiga, atau Internet. Kami berhak menghentikan penggunaan Anda atas Situs Web dan Layanan karena melanggar salah satu penggunaan yang dilarang.</p>
            <h5 id="intellectual-property-rights" class="fw-bold">Hak kekayaan intelektual</h5>
            <p>&#8220;Hak Kekayaan Intelektual&#8221; berarti semua hak sekarang dan yang akan datang yang diberikan oleh undang-undang, hukum adat atau ekuitas dalam atau sehubungan dengan hak cipta dan hak terkait, merek dagang, desain, paten, penemuan, niat baik dan hak untuk menuntut karena meninggal, hak atas penemuan, hak untuk menggunakan , dan semua hak kekayaan intelektual lainnya, dalam setiap kasus apakah terdaftar atau tidak terdaftar dan termasuk semua aplikasi dan hak untuk mengajukan dan diberikan, hak untuk mengklaim prioritas dari, hak tersebut dan semua hak atau bentuk perlindungan yang serupa atau setara dan hasil lainnya aktivitas intelektual yang ada atau akan ada sekarang atau di masa depan di belahan dunia mana pun. Perjanjian ini tidak mentransfer kepada Anda kekayaan intelektual apa pun yang dimiliki oleh Operator atau pihak ketiga, dan semua hak, kepemilikan, dan kepentingan dalam dan terhadap properti tersebut akan tetap (di antara para pihak) hanya dengan Operator. Semua merek dagang, merek layanan, grafik, dan logo yang digunakan sehubungan dengan Situs Web dan Layanan, adalah merek dagang atau merek dagang terdaftar dari Operator atau pemberi lisensinya. Merek dagang, merek layanan, grafik, dan logo lain yang digunakan sehubungan dengan Situs Web dan Layanan mungkin merupakan merek dagang dari pihak ketiga lainnya. Penggunaan Anda atas Situs Web dan Layanan tidak memberi Anda hak atau lisensi untuk mereproduksi atau menggunakan merek dagang Operator atau pihak ketiga mana pun.</p>
            <h5 id="limitation-of-liability" class="fw-bold">Batasan tanggung jawab</h5>
            <p>Sejauh diizinkan oleh undang-undang yang berlaku, Operator, afiliasinya, direktur, pejabat, karyawan, agen, pemasok, atau pemberi lisensinya tidak akan bertanggung jawab kepada siapa pun atas kerugian tidak langsung, insidental, khusus, hukuman, pertanggungan, atau konsekuensial ( termasuk, tanpa batasan, ganti rugi atas hilangnya keuntungan, pendapatan, penjualan, niat baik, penggunaan konten, dampak pada bisnis, gangguan bisnis, kehilangan tabungan yang diantisipasi, kehilangan peluang bisnis) bagaimanapun penyebabnya, berdasarkan teori tanggung jawab apa pun, termasuk, tanpa batasan , kontrak, kesalahan, jaminan, pelanggaran kewajiban hukum, kelalaian atau lainnya, bahkan jika pihak yang bertanggung jawab telah diberitahu tentang kemungkinan kerusakan tersebut atau dapat memperkirakan kerusakan tersebut. Sejauh diizinkan oleh undang-undang yang berlaku, tanggung jawab keseluruhan dari Operator dan afiliasinya, petugas, karyawan, agen, pemasok, dan pemberi lisensi yang terkait dengan layanan akan dibatasi pada jumlah yang tidak lebih dari satu dolar atau jumlah yang sebenarnya dibayarkan secara tunai. oleh Anda kepada Operator untuk periode satu bulan sebelumnya sebelum peristiwa atau kejadian pertama yang menimbulkan tanggung jawab tersebut. Batasan dan pengecualian juga berlaku jika pemulihan ini tidak sepenuhnya memberikan kompensasi kepada Anda atas kerugian atau kegagalan tujuan utamanya.</p>
            <h5 id="indemnification" class="fw-bold">Ganti Rugi</h5>
            <p>Anda setuju untuk mengganti rugi dan membebaskan Operator dan afiliasinya, direktur, pejabat, karyawan, agen, pemasok, dan pemberi lisensinya dari dan terhadap kewajiban, kerugian, kerusakan, atau biaya apa pun, termasuk tanggung jawab pengacara yang wajar. biaya, yang dikeluarkan sehubungan dengan atau timbul dari tuduhan, klaim, tindakan, perselisihan, atau tuntutan pihak ketiga mana pun yang ditegaskan terhadap salah satu dari mereka sebagai akibat dari atau terkait dengan Konten Anda, penggunaan Anda atas Situs Web dan Layanan atau kesalahan yang disengaja pada Anda bagian.</p>
            <h5 id="severability" class="fw-bold">Keterpisahan</h5>
            <p>Semua hak dan pembatasan yang terkandung dalam Perjanjian ini dapat dilaksanakan dan akan berlaku dan mengikat hanya sejauh tidak melanggar hukum yang berlaku dan dimaksudkan untuk dibatasi sejauh yang diperlukan sehingga tidak akan menjadikan Perjanjian ini ilegal, tidak sah atau tidak dapat dilaksanakan. Jika ada ketetapan atau bagian dari ketetapan apapun dari Perjanjian ini akan dianggap ilegal, tidak sah atau tidak dapat dilaksanakan oleh pengadilan dengan yurisdiksi yang kompeten, para pihak bermaksud agar sisa ketetapan atau bagian darinya akan menjadi persetujuan mereka sehubungan dengan pokok bahasannya, dan semua ketentuan atau bagian lainnya yang tersisa akan tetap berlaku sepenuhnya.</p>
            <h5 id="dispute-resolution" class="fw-bold">Penyelesaian Sengketa</h5>
            <p>Pembentukan, interpretasi, dan pelaksanaan Perjanjian ini dan setiap perselisihan yang timbul darinya akan diatur oleh hukum substantif dan prosedural Indonesia tanpa memperhatikan aturannya tentang konflik atau pilihan hukum dan, sejauh yang berlaku, hukum Indonesia . Yurisdiksi eksklusif dan tempat untuk tindakan yang berkaitan dengan pokok bahasan ini adalah pengadilan yang berlokasi di Indonesia, dan Anda dengan ini tunduk pada yurisdiksi pribadi pengadilan tersebut. Anda dengan ini melepaskan hak atas sidang juri dalam proses apa pun yang timbul dari atau terkait dengan Perjanjian ini. Konvensi Perserikatan Bangsa-Bangsa tentang Kontrak untuk Penjualan Barang Internasional tidak berlaku untuk Perjanjian ini.</p>
            <h5 id="changes-and-amendments" class="fw-bold">Perubahan dan Amandemen</h5>
            <p>Kami berhak untuk mengubah Perjanjian ini atau syarat-syaratnya yang terkait dengan Situs Web dan Layanan kapan saja sesuai kebijaksanaan kami. Ketika kami melakukannya, kami akan mengirimkan email untuk memberi tahu Anda. Kami juga dapat memberikan pemberitahuan kepada Anda dengan cara lain sesuai kebijaksanaan kami, seperti melalui informasi kontak yang Anda berikan.</p>
            <p>Versi terbaru dari Perjanjian ini akan berlaku segera setelah posting dari Perjanjian yang direvisi kecuali ditentukan lain. Penggunaan Anda yang berkelanjutan atas Situs Web dan Layanan setelah tanggal berlakunya Perjanjian yang direvisi (atau tindakan lain yang ditentukan pada saat itu) akan merupakan persetujuan Anda atas perubahan tersebut.</p>
            <h5 id="acceptance-of-these-terms" class="fw-bold">Penerimaan persyaratan ini</h5>
            <p>Anda mengakui bahwa Anda telah membaca Perjanjian ini dan menyetujui semua syarat dan ketentuannya. Dengan mengakses dan menggunakan Situs Web dan Layanan, Anda setuju untuk terikat dengan Perjanjian ini. Jika Anda tidak setuju untuk mematuhi ketentuan Perjanjian ini, Anda tidak berwenang untuk mengakses atau menggunakan Situs Web dan Layanan. Kebijakan syarat dan ketentuan ini dibuat dengan bantuan <a href="https://www.websitepolicies.com" target="_blank" rel="nofollow">Kebijakan Situs Web</a>.</p>
            <h5 id="contacting-us" class="fw-bold">Hubungi kami</h5>
            <p>Jika Anda memiliki pertanyaan, kekhawatiran, atau keluhan terkait Perjanjian ini, kami mendorong Anda untuk menghubungi kami menggunakan perincian di bawah ini:</p>
            <p><a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;e&#114;ef&#105;v.&#105;d&#64;&#103;&#109;&#97;&#105;&#108;.com">er&#101;f&#105;&#118;.&#105;&#100;&#64;&#103;m&#97;&#105;&#108;.com</a><br/>Jalan Pegangsaan Timur 78</p>
            <p>Dokumen ini terakhir diperbarui pada 22 November 2022</p>
        </div>

        <div class="d-flex justify-content-center" style="height: 140px; background-color:#BA7967; color:#3F4441;">
            <form action="" method="post">
                <div class="row w-100 mx-0 d-flex">
                    <div class="col-lg-1 col-sm-0"></div>
                    <div class="col-lg-5 mt-lg-4 mt-2 me-lg-5 col-sm-12 text-white">
                        <h1 class="fw-bolder">REGISTER NOW FOR SPECIAL OFFERS</h1>
                    </div>
                    <div class="col-lg-5 mt-lg-5 mt-2 d-flex">
                        <div class="form-field">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="passingEmail" class="input" autocomplete="off">
                            <div class="border-line">
                            </div>
                        </div>
                        <button type="submit" class="mb-4" style="background:none; border: none;" name="passing">
                            <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                        </button>
                    </div>
                </div>
            </form>
        </div>
       
    </div>
    <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
        <div class="col-lg-1 me-lg-5 gambar"></div>
        <div class="col-lg-2 mt-lg-3 gambar">
            <h5 class="fw-bold mb-2">Categories</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                <li><a href="catalogue.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                <li><a href="catalogue.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                <li><a href="catalogue.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                <li><a href="catalogue.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                <li><a href="catalogue.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                <li><a href="catalogue.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                <li><a href="catalogue.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                <li><a href="catalogue.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                <li><a href="catalogue.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                <li><a href="catalogue.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                <li><a href="catalogue.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                <li><a href="catalogue.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                <li><a href="catalogue.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                <li><a href="catalogue.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                <li><a href="catalogue.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                <li><a href="catalogue.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                <li><a href="catalogue.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                <li><a href="catalogue.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                <li><a href="catalogue.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                <li><a href="catalogue.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                <li><a href="catalogue.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                <li><a href="catalogue.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                <li><a href="catalogue.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-3 col-sm-6 gambar">
            <h5 class="fw-bold mb-2">Legal</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
            </ul>
            <h5 class="fw-bold mb-2 mt-2">Support</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
            </ul> 
        </div>
        <div class="hp">
            <div class="row">
                <div class="col-6">
                    <h5 class="fw-bold mb-2">Legal</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                        <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-6">
                    <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Support</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
        &#169; 2022 Erefir Indonesia
    </footer>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        // function menuToggle() {
        //     const toggleMenu = document.querySelector(".menu");
        //     toggleMenu.classList.toggle("active");
        // }
        
        $(document).ready(function(){
       	  $(".input").focus(function(){
       	  	 $(this).parent(".form-field").addClass("active")
       	  })
       	  $(".input").blur(function(){
       	  	 if($(this).val()==""){
       	  	   $(this).parent(".form-field").removeClass("active")
       	  	}
       	  })
       })
    </script>
</body>
</html>