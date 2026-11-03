<?php
/**
 * Foto mahasiswa, atau inisial nama jika foto belum diunggah.
 *
 * @var array  $m     data mahasiswa (nama, foto)
 * @var string $class class tambahan, mis. "avatar-xl"
 */
$class ??= '';
?>
<?php if (! empty($m['foto'])) : ?>
    <img src="<?= base_url('uploads/mahasiswa/' . esc($m['foto'], 'url')) ?>" alt="Foto <?= esc($m['nama']) ?>"
         class="avatar <?= esc($class, 'attr') ?>" width="48" height="48" loading="lazy">
<?php else : ?>
    <?php
    $kata    = preg_split('/\s+/', trim($m['nama']));
    $inisial = strtoupper(substr($kata[0], 0, 1) . (isset($kata[1]) ? substr($kata[1], 0, 1) : ''));
    ?>
    <span class="avatar <?= esc($class, 'attr') ?>" aria-hidden="true"><?= esc($inisial) ?></span>
<?php endif ?>
