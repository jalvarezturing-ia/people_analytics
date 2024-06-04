<?php $session = session();
$rol = $session->get('rol');

if ($rol == 'directivo'): ?>

    <?= $this->include('direccion/header') ?>

<?php elseif($rol == 'admin1'): ?>
   
    <?= $this->include('comercial/administracionGeneral/header') ?>

<?php elseif($rol == 'admin2'): ?>

    <?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<?php elseif($rol == 'colab'): ?>

    <?= $this->include('colaboradores/header') ?>

<?php endif; ?>