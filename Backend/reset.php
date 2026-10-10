<?php
$s = App\Models\Service::find('S001');
if ($s) {
    $s->status = 'Diproses';
    $s->saveQuietly();
    App\Models\Warranty::where('id_service', 'S001')->delete();
    echo "Reset S001 sukses";
}
