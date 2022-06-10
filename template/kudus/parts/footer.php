<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:26:05+07:00
# @Email:  ido.alit@gmail.com
# @Filename: footer.php
# @Last modified by:   user
# @Last modified time: 2018-01-23T11:26:47+07:00
?>


<footer class="py-4 bg-grey-darkest text-grey-lighter">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-3">
                <svg
                        class="fill-current text-grey-lighter block h-12 w-12 mb-2"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 118.4 135" style="enable-background:new 0 0 118.4 135;"
                        xml:space="preserve">
                    <path d="M118.3,98.3l0-62.3l0-0.2c-0.1-1.6-1-3-2.3-3.9c-0.1,0-0.1-0.1-0.2-0.1L61.9,0.8c-1.7-1-3.9-1-5.4-0.1l-54,31.1
                    l-0.4,0.2C0.9,33,0.1,34.4,0,36c0,0.1,0,0.2,0,0.3l0,62.4l0,0.3c0.1,1.6,1,3,2.3,3.9c0.1,0.1,0.2,0.1,0.2,0.2l53.9,31.1l0.3,0.2
                    c0.8,0.4,1.6,0.6,2.4,0.6c0.8,0,1.5-0.2,2.2-0.5l53.9-31.1c0.3-0.1,0.6-0.3,0.9-0.5c1.2-0.9,2-2.3,2.1-3.7c0-0.1,0-0.3,0-0.4
                    C118.4,98.6,118.3,98.5,118.3,98.3z M114.4,98.8c0,0.3-0.2,0.7-0.5,0.9c-0.1,0.1-0.2,0.1-0.2,0.1l-20.6,11.9L59.2,92.1l-33.9,19.6
                    L4.6,99.7l0,0l0,0C4.2,99.5,4,99.2,4,98.8l0-62.5l0,0l0-0.1c0-0.4,0.2-0.7,0.5-0.9l20.8-12l33.9,19.6l33.9-19.6l20.6,11.9l0.1,0
                    c0.3,0.2,0.5,0.5,0.6,0.9l0,62.3L114.4,98.8L114.4,98.8z M95.3,68.6v39.4L23.1,66.4V26.9L95.3,68.6z"/>
                </svg>
                <h4 class="mb-4">Link E-book</h4>
                <ul class="list-reset">
                    <li><a class="text-light" href="https://bse.kemdikbud.go.id/#!/Home/Welcome">E-book Kemdikbud</a></li>
                    <li><a class="text-light" href="http://buku.kemdikbud.go.id/">Buku Kemdikbud</a></li>
                    <li><a class="text-light" href="http://iindramayu.moco.co.id/">E-book Perpusda Indramayu</li>
                    <li><a class="text-light" href="https://belajar.kemdikbud.go.id/">Rumah Belajar Kemdikbud</a></li>
                </ul>
            </div>
            <div class="col-md-5 pt-8 md:pt-0">
                <h4 class="mb-4">Tentang Kami</h4>
                <p>Penerapan Otomasi Perpustakaan menjadikan Perpustakaan Ulil Albab semakin lengkap dan menyenangkan untuk siswa.
Pengguna dapat menggunakan fasilitas perpustakaan diantaranya OPAC (Online Public Access Catalog) serta link e-book secara gratis,  Sehingga siswa dengan mudahnya dalam searching buku dari gadget  atau perangkat teknologi lainnya. Tunggu Apalagi, yuk gabung di Perpustakaan Ulil Albab SMAN 1 Anjatan Kab. Indramayu. </p>
            </div>
            <div class="col-md-4 pt-8 md:pt-0">
                <h4 class="mb-4">Cari Buku</h4>
                <div class="mb-2">
Mulai dengan mengetik satu atau lebih kata kunci untuk judul, penulis atau subjek</div>
                <form action="index.php">
                    <div class="input-group mb-3">
                        <input name="keywords" type="text" class="form-control" placeholder="Enter keywords"
                               aria-label="Enter keywords"
                               aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" value="search" name="search"
                                    id="button-addon2">Find Collection
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <a target="_blank" title="Support Us" class="btn btn-outline-success mb-2"
                   href="https://slims.web.id/web/pages/support-us/"><i
                            class="fas fa-heart mr-2"></i><?= __('Keep SLiMS Alive'); ?></a>
                <a target="_blank" title="Contribute" class="btn btn-outline-light mb-2"
                   href="https://github.com/slims/"><i
                            class="fab fa-github mr-2"></i><?= __('Want to Contribute?'); ?></a>
            </div>
        </div>
        <hr>
        <div class="flex font-thin text-sm">
            <p class="flex-1">&copy; <?php echo date('Y'); ?> &mdash; Senayan Developer Community</p>
            <div class="flex-1 text-right text-grey">Powered by <code>SLiMS</code></div>
        </div>
    </div>
</footer>

<a target="_blank" class="js-back-to-top back-to-top back-to-top-is-visible back-to-top-fade-out" href="https://api.whatsapp.com/send?phone=6282320570863&amp;text=Assalamualaikum  Wr. Wb. Punten Bu%20saya%20mau%20tanya. Saya siswa/i SMAN 1 Anjatan. Nama saya "><i class="fab fa-whatsapp mr-2"></i> Chat Pustakawan</a>

<script>
$(document).ready(function($){
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.js-back-to-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('back-to-top-is-visible') : $back_to_top.removeClass('back-to-top-is-visible back-to-top-fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $back_to_top.addClass('back-to-top-fade-out');
        }
    });


});
</script>

<?php if ($sysconf['chat_system']['enabled'] && $sysconf['chat_system']['opac']) : ?>
    <div id="show-pchat2" style="position: fixed; bottom: 16px; right: 16px" class="shadow rounded">
        <button title="Chat" class="btn btn-primary"><i class="fas fa-comments mr-2"></i><?= __('Chat'); ?></button>
    </div>
<?php endif; ?>

<?php
// Chat Engine
include LIB . "contents/chat.php"; ?>

<!-- // Load modal -->
<?php include "_modal_topic.php"; ?>
<?php include "_modal_advanced.php"; ?>

<!-- // load our vue app.js -->
<script src="<?php echo assets('js/app.js?v=' . date('Ymd-his')); ?>"></script>
<script src="<?php echo assets('js/app_jquery.js?v=' . date('Ymd-his')); ?>"></script>
<?php include __DIR__ . "./../assets/js/vegas.js.php"; ?>
<?php if ($sysconf['chat_system']['enabled'] && $sysconf['chat_system']['opac']) : ?>
    <script>
        $('#show-pchat').click(() => {
            $('.s-chat').hide()
            $('#show-pchat2').show()
        })
        $('#show-pchat2').click(() => {
            $('.s-chat').show(300, () => {
                $('#show-pchat2').hide()
            })
        })
    </script>
<?php endif; ?>
</body>
</html>
