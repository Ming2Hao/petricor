<?php
    require_once("connection.php");
    // if(isset($_POST['passing'])){
    //     $_SESSION['emailPassing'] = $_POST['passingEmail'];
    //     header('Location: register.php');
    // }
    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (!isset($_SESSION['currentUser'])) header("Location: index.php");

    $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    $curUser = mysqli_fetch_array($user);
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
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <style>
        @media screen and (min-device-width: 300px) and (max-device-width: 500px) { 
            .gambar{
                display: none;
            }
            /* .futer{
                display: none;
            } */
        }
        @media screen and (min-width:1000px){
            .gambar{
                display: block;
            }
            /* .futer{
                display: flex;
            } */
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

        html, body{
            width: 100%;
        }

        /* PROFILE */
        .action {
            position: fixed;
            top: 10px;
            right: 30px;
        }

        .action .profile {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }

        .action .profile img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .action .menu {
            position: absolute;
            top: 120px;
            right: -10px;
            background: #fff;
            width: 200px;
            box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            transition: 0.5s;
            visibility: hidden;
            opacity: 0;
        }

        .action .menu.active {
            top: 50px;
            visibility: visible;
            opacity: 1;
        }

        .action .menu::before {
            content: "";
            position: absolute;
            top: 0px;
            right: 28px;
            width: 20px;
            height: 20px;
            background: #fff;
            transform: rotate(45deg);
        }

        .action .menu .username {
            width: 100%;
            text-align: center;
            font-size: 18px;
            padding: 15px 0px 0px 0px;
            font-weight: 500;
            color: #555;
        }

        .action .menu .printilan {
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #cecece;
        }

        /* .action .menu h3 span {
            font-size: 14px;
            color: #cecece;
            font-weight: 300;
        } */

        .action .menu ul li {
            list-style: none;
            padding: 16px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .action .menu ul li img {
            max-width: 20px;
            margin-right: 10px;
            opacity: 0.5;
            transition: 0.5s;
        }

        .action .menu ul li:hover img {
            opacity: 1;
        }

        .action .menu ul li a {
            display: inline-block;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: 0.5s;
        }

        .action .menu ul li:hover a {
            color: #ff5d94;
        }

        /* KERANJANG */
        .badge:after{
            content:attr(value);
            font-size:15px;
            color: #fff;
            background: red;
            border-radius:50%;
            padding: 0 5px;
            position:relative;
            left:-8px;
            top:-10px;
            opacity:0.9;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
    <div class="container-fluid px-0">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="indexSudahLogin.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white"></div>
            </a>
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
            <div class="d-flex justify-content-end">
                <a href="cart.php" class="me-5 pe-3 d-flex">
                    <?php
                        $userIni = $curUser["us_id"];
                        $hitungCart = mysqli_query($conn, "SELECT COUNT(ct_it_id) FROM cart WHERE ct_us_id = '$userIni'");
                        $qtyCart = mysqli_fetch_row($hitungCart);
                    ?>
                    <i class="fa badge fa-lg p-0" value="<?=$qtyCart[0]?>">&#xf07a;</i>
                </a>
                <div class="d-lg-flex d-sm-block">
                    <!-- PROFILEEEEEEEEEE USERRRRRRR -->
                    <div class="action">
                        <div class="profile" onclick="menuToggle();">
                            <img src="temp/nahida2.jpg">
                        </div>
                        <div class="menu">
                            <div class="username" style="margin-bottom: -5px">
                                <?=$curUser["us_name"]?>
                            </div>
                            <div class="printilan"><?=$curUser["us_username"]?> </div>
                            <ul>
                            <li>
                                <img src="assets/img/logout.png" /><a href="index.php">Logout</a>
                            </li>
                            </ul>
                        </div>  
                    </div>
                    
                </div>
            </div>

        </div>
    </nav>

        <div class="pt-2 px-2 px-lg-2 col-lg-10 col-12">
            <h2 class="fw-bold">Kebijakan Privasi</h2>
            Website erefiv dimiliki oleh Erefiv, yang akan menjadi pengontrol atas data pribadi Anda. <br>
            Kami telah mengadopsi Kebijakan Privasi ini untuk menjelaskan bagaimana kami memproses informasi yang dikumpulkan oleh erefiv, yang juga menjelaskan alasan mengapa kami perlu mengumpulkan data pribadi tertentu tentang Anda. Oleh karena itu, Anda harus membaca Kebijakan Privasi ini sebelum menggunakan website erefiv.<br>
            Kami menjaga data pribadi Anda dan berjanji untuk menjamin kerahasiaan dan keamanannya. <br><br>
            <h5 class="fw-bold">Informasi pribadi yang kami kumpulkan:</h5>
            Saat Anda mengunjungi erefiv, kami secara otomatis mengumpulkan informasi tertentu mengenai perangkat Anda, termasuk informasi tentang browser web, alamat IP, zona waktu, dan sejumlah cookie yang terinstal di perangkat Anda. Selain itu, selama Anda menjelajahi Website, kami mengumpulkan informasi tentang setiap halaman web atau produk yang Anda lihat, website atau istilah pencarian apa yang mengarahkan Anda ke Website, dan cara Anda berinteraksi dengan Website. Kami menyebut informasi yang dikumpulkan secara otomatis ini sebagai "Informasi Perangkat". Kemudian, kami mungkin akan mengumpulkan data pribadi yang Anda berikan kepada kami (termasuk tetapi tidak terbatas pada, Nama, Nama belakang, Alamat, informasi pembayaran, dll.) selama pendaftaran untuk dapat memenuhi perjanjian. <br><br>
            <h5 class="fw-bold">Mengapa kami memproses data Anda?</h5>
            Menjaga data pelanggan agar tetap aman adalah prioritas utama kami. Oleh karena itu, kami hanya dapat memproses sejumlah kecil data pengguna, sebanyak yang benar-benar diperlukan untuk menjalankan website. Informasi yang dikumpulkan secara otomatis hanya digunakan untuk mengidentifikasi kemungkinan kasus penyalahgunaan dan menyusun informasi statistik terkait penggunaan website. Informasi statistik ini tidak digabungkan sedemikian rupa hingga dapat mengidentifikasi pengguna tertentu dari sistem. <br><br>

            Anda dapat mengunjungi website tanpa memberi tahu kami identitas Anda atau mengungkapkan informasi apa pun, yang dapat digunakan oleh seseorang untuk mengidentifikasi Anda sebagai individu tertentu yang dapat dikenali. Namun, jika Anda ingin menggunakan beberapa fitur website, atau Anda ingin menerima newsletter kami atau memberikan detail lainnya dengan mengisi formulir, Anda dapat memberikan data pribadi kepada kami, seperti email, nama depan, nama belakang, kota tempat tinggal, organisasi, dan nomor telepon Anda. Anda dapat memilih untuk tidak memberikan data pribadi Anda kepada kami, tetapi Anda mungkin tidak dapat memanfaatkan beberapa fitur website. Contohnya, Anda tidak akan dapat menerima Newsletter kami atau menghubungi kami secara langsung dari website. Pengguna yang tidak yakin tentang informasi yang wajib diberikan dapat menghubungi kami melalui <span style="color:#5E6F64; font-weight:bold">erefiv.id@gmail.com</span>. <br><br>
            <h5 class="fw-bold">Hak-hak Anda:</h5>
            Jika Anda seorang warga Indonesia, Anda memiliki hak-hak berikut terkait data pribadi Anda: <br>
            <ul>
                <li>Hak untuk mendapatkan penjelasan.</li>
                <li>Hak atas akses.</li>
                <li>Hak untuk memperbaiki.</li>
                <li>Hak untuk menghapus.</li>
                <li>Hak untuk membatasi pemrosesan.</li>
                <li>Hak atas portabilitas data.</li>
                <li>Hak untuk menolak.</li>
                <li>Hak-hak terkait pengambilan keputusan dan pembuatan profil otomatis.</li>
            </ul>
            Jika Anda ingin menggunakan hak ini, silakan hubungi kami melalui informasi kontak di bawah ini: <br>
            <div class="ms-lg-3" style="font-size:15px;">
                +62-822-7898-2345 <br>
                <!-- CustomerCare@erefiv.com <br> -->
                erefiv ID <br>
                78245 Surabaya <br>
                Indonesia <br> <br>
            </div>
            Selain itu, jika Anda seorang warga Indonesia, perlu diketahui bahwa kami akan memproses informasi Anda untuk memenuhi kontrak yang mungkin kami miliki dengan Anda (misalnya, jika Anda melakukan pemesanan melalui Website), atau untuk memenuhi kepentingan bisnis sah kami seperti yang tercantum di atas. Di samping itu, harap diperhatikan bahwa informasi Anda mungkin dapat dikirim ke luar Indonesia, termasuk Singapura dan Malaysia. <br><br>
            <h5 class="fw-bold">Link ke website lain:</h5>
            Website kami mungkin berisi tautan ke website lain yang tidak dimiliki atau dikendalikan oleh kami. Perlu diketahui bahwa kami tidak bertanggung jawab atas praktik privasi website lain atau pihak ketiga. Kami menyarankan Anda untuk selalu waspada ketika meninggalkan website kami dan membaca pernyataan privasi setiap website yang mungkin mengumpulkan informasi pribadi. <br> <br>
            <h5 class="fw-bold">Keamanan informasi:</h5>
            Kami menjaga keamanan informasi yang Anda berikan pada server komputer dalam lingkungan yang terkendali, aman, dan terlindungi dari akses, penggunaan, atau pengungkapan yang tidak sah. Kami menjaga pengamanan administratif, teknis, dan fisik yang wajar untuk perlindungan terhadap akses, penggunaan, modifikasi, dan pengungkapan tidak sah atas data pribadi dalam kendali dan pengawasannya. Namun, kami tidak menjamin tidak akan ada transmisi data melalui Internet atau jaringan nirkabel. <br> <br>
            <h5 class="fw-bold">Pengungkapan hukum:</h5>
            Kami akan mengungkapkan informasi apa pun yang kami kumpulkan, gunakan, atau terima jika diwajibkan atau diizinkan oleh hukum, misalnya untuk mematuhi panggilan pengadilan atau proses hukum serupa, dan jika kami percaya dengan itikad baik bahwa pengungkapan diperlukan untuk melindungi hak kami, melindungi keselamatan Anda atau keselamatan orang lain, menyelidiki penipuan, atau menanggapi permintaan dari pemerintah. <br><br>
            <h5 class="fw-bold">Informasi kontak:</h5>
            Jika Anda ingin menghubungi kami untuk mempelajari Kebijakan ini lebih lanjut atau menanyakan masalah apa pun yang berkaitan dengan hak perorangan dan Informasi pribadi Anda, Anda dapat mengirim email ke <span style="color:#5E6F64; font-weight:bold">erefiv.id@gmail.com</span>. <br> <br>
        </div>
        <hr style="color:#BA7967" class="gambar">
       
    </div>
    <div class="row gambar container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
            <div class="col-lg-1 me-lg-5"></div>
            <div class="col-lg-2 mt-lg-3">
                <h5 class="fw-bold mb-2">Categories</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-3">
                <h5 class="fw-bold mb-2">Legal</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="#" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                    <li><a href="" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                </ul>
                <h5 class="fw-bold mb-2 mt-2">Support</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                    <!-- <li><a href="" style="text-decoration:none; color:#57615b">Pembayaran</a></li> -->
                </ul>
            </div>
        </div>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
</body>
</html>