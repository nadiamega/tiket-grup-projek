<?php
?>

<div class="mb-10 flex items-start justify-between">

    <!-- Bagian Judul -->
    <div>

        <?php if (!empty($back_link)) : ?>

            <a href="<?php echo $back_link; ?>"
               class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-black transition">

                ← Kembali

            </a>

        <?php endif; ?>


        <h2 class="text-[32px] font-black text-gray-900 tracking-tight <?php echo !empty($back_link) ? 'mt-4' : ''; ?>">

            <?php echo $page_title ?? ''; ?>

        </h2>


        <?php if (!empty($page_subtitle)) : ?>

            <p class="text-sm text-gray-400 font-medium tracking-tight">

                <?php echo $page_subtitle; ?>

            </p>

        <?php endif; ?>

    </div>


    <!-- Avatar Profile -->
    <a href="profile.php"
       class="w-10 h-10
              bg-black
              rounded-full
              flex
              items-center
              justify-center
              text-white
              font-bold
              shadow-lg
              uppercase
              shrink-0
              hover:scale-105
              hover:shadow-xl
              transition-all
              duration-200"
       title="Profile">

        <?php
        echo strtoupper(substr($_SESSION['username'], 0, 1));
        ?>

    </a>

</div>


<?php
unset($page_title, $page_subtitle, $back_link);
?>