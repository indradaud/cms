<?php

use Landingo\Resources\Dbase;

$db = new Dbase();

switch($this->_act) :

default :
?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li class="active">User</li>
</ol>

<div class="col-sm-8">
<div class="page-header">
    <h2>Semua User</h2>
</div>

<?php

$users = $db->get('users')->resultAll();

?>

<table class="table table-striped table-hover">
  <thead>
      <tr>
          <th width="40px">#</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Level</th>
          <th>Tindakan</th>
      </tr>
  </thead>
  <tbody>
      <?php $no = 1; ?>
      <?php foreach($users as $user) : ?>
        <tr>
            <td><?=$no?></td>
            <td><?=$user->nama?></td>
            <td><?=$user->email?></td>
            <td><?=ucfirst($user->level)?></td>
            <td>
                <a href="<?=$base_url?>/index.php/admin/user/edit/<?=$user->id?>" class="text-warning">
                  <span class="fa fa-pencil-square-o"></span>Edit
                </a>
                <a href="<?=$base_url?>/index.php/admin/user/hapus/<?=$user->id?>" class="text-danger">
                  <span class="fa fa-times-circle-o"></span>Hapus
                </a>
            </td>
        </tr>
      <?php $no++ ?>
      <?php endforeach; ?>
  </tbody>
</table>

<div class="page-header">
    <h3>Tambah User</h3>
</div>

<form method="post" action="<?=$base_url?>/index.php/admin/user/tambah">
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input name="nama" type="text" class="form-control" placeholder="Nama">
    </div>
</div>
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input name="email" type="text" class="form-control" placeholder="Email">
    </div>
</div>
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input name="password" type="password" class="form-control" placeholder="Password">
    </div>
</div>
<div class="form-group col-sm-8">
    <select name="level" class="form-control">
        <option value="">Level</option>
        <option value="superuser">Superuser</option>
        <option value="user">User</option>
    </select>
</div>
<div class="form-group col-sm-8">
<button value="true" class="btn btn-success btn-sm" type="submit" name="form_send_user">
    <span class="fa fa-user-plus"></span>
    Tambahkan
</button>
</div>
</form>
</div>

<?php break; ?>

<?php case 'tambah' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/user">User</a></li>
    <li class="active">Tambah</li>
</ol>

<div class="col-sm-8">
<div class="page-header">
    <h2>Tambahkan User</h2>
</div>

<?php if(!isset($_POST['form_send_user'])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada user yang ditambahkan !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php $error = 0; ?>
<?php foreach($_POST as $key => $value) : ?>

<?php if(empty($_POST["{$key}"])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Form <b><?=$key?></b> kosong !
</div>

<?php $error++?>
<?php endif; ?>

<?php endforeach; ?>

<?php if($error) : ?>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php

$data = array('',
              $_POST['email'],
              md5($_POST['password']),
              $_POST['nama'],
              $_POST['level']
);

$run = $db->insert('users', $data)->rowCount();

?>

<?php if($run) : ?>

<div class="alert alert-success">
User berhasil ditambahkan !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>
<?php endif; ?>

</div>
<?php break; ?>

<?php case 'edit' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/user">User</a></li>
    <li class="active">Edit</li>
</ol>

<div class="col-sm-8">
<div class="page-header">
    <h2>Edit User</h2>
</div>

<?php if(!isset($this->_params[0])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada user yang dipilih !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php 

$userid = (int)$this->_params[0];

$db->where = "id = {$userid}";
$user = $db->get('users')->result();

$db->reset(array('where'));
?>

<?php if(!$user) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! User dengan id <?=$userid;?> tidak ditemukan !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>


<form method="post" action="<?=$base_url?>/index.php/admin/user/perbarui">
<div class="form-group col-sm-8">
    <input type="hidden" name="userid" value="<?=$user->id?>">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input name="nama" value="<?=$user->nama?>" type="text" class="form-control" placeholder="Nama">
    </div>
</div>
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input name="email" value="<?=$user->email?>" type="text" class="form-control" placeholder="Email">
    </div>
</div>
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input name="password" type="password" class="form-control" placeholder="Password Baru">
    </div>
</div>
<div class="form-group col-sm-8">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input name="old_password" type="password" class="form-control" placeholder="Password Lama">
    </div>
</div>
<div class="form-group col-sm-8">
    <select name="level" class="form-control">
        <?php if($user->level === 'superuser') : ?>
        <option value="superuser" selected>Superuser</option>
        <option value="user">User</option>
        <?php else : ?>
        <option value="superuser">Superuser</option>
        <option value="user" selected>User</option>
        <?php endif; ?>
    </select>
</div>
<div class="form-group col-sm-8">
<input type="submit" class="btn btn-success btn-sm" name="form_send_user_edit" value="Simpan">
</div>
</form>

</div>
<?php break; ?>

<?php case 'perbarui' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/user">User</a></li>
    <li class="active">Perbarui</li>
</ol>

<div class="col-sm-8">
<div class="page-header">
    <h2>Perbarui User</h2>
</div>

<?php if(!isset($_POST['form_send_user_edit'])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada user yang diperbarui !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php

$userid = $_POST['userid'];
$password = md5($_POST['old_password']);

$db->where = "id = {$userid}";
$db->row = 'password';
$user = $db->get('users')->result();

?>

<?php if($password !== $user->password) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Password lama salah !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php

if(!empty($_POST['password']))
{
    $password = md5($_POST['password']);
}

$data = array(
    'email' => $_POST['email'],
    'password' => $password,
    'nama' => $_POST['nama'],
    'level' => $_POST['level']
);

$run = $db->update('users', $data)->rowCount();

$db->reset(array('where'));

?>

<?php if($run) : ?>

<div class="alert alert-success">
User berhasil diperbarui !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>
<?php endif; ?>

</div>

</div>
<?php break; ?>

<?php case 'hapus' ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/user">User</a></li>
    <li class="active">Hapus</li>
</ol>

<div class="col-sm-8">
<div class="page-header">
    <h2>Hapus User</h2>
</div>

<?php if(!isset($this->_params[0])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada user yang dipilih !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php

$userid = $this->_params[0];

$db->where = "id = {$userid}";

?>

<?php if($userid == 3) : ?>

<div class="alert alert-danger">
Forribiden ! Access denied !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>

<?php return; ?>
<?php endif; ?>

<?php

$run = $db->delete('users')->rowCount();

$db->reset(array('where'));

?>

<?php if($run) : ?>

<div class="alert alert-success">
User berhasil dihapus !
</div>
<a href="<?=$base_url?>/index.php/admin/user">&larr; Kembali ke User</a>
<?php endif; ?>

</div>

</div>
<?php break; ?>

<?php endswitch; ?>