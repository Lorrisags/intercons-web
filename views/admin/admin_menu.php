<?php
/*
 * Path File: /views/admin/admin_menu.php
 * Deskripsi: Halaman Admin untuk mengatur nama dan visibilitas Menu Navigasi pengunjung.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil pengaturan menu saat ini dari database
$query = "SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'menu_%'";
$stmt = $db->prepare($query);
$stmt->execute();

$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Daftar menu default
// Daftar menu default
$menu_list = [
    'home' => 'Home',
    'about' => 'About',
    'page' => 'Page (Dropdown)',
    'gallery' => '-- Sub: Gallery',
    'team' => '-- Sub: Team',
    'career' => '-- Sub: Experience', // <--- Ubah bagian ini
    'service' => 'Service',
    'product' => 'Product Catalogue',
    'contact' => 'Contact'
];
?>
<!-- Header Halaman -->
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-bars fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan Navigasi Menu</h3>
        <p class="text-muted mb-0 small">Ubah nama menu atau sembunyikan menu yang tidak ingin ditampilkan ke pengunjung.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-5">
    <div class="card-body p-4 bg-light">
        <form action="process_update_menu.php" method="POST">
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white shadow-sm rounded overflow-hidden">
                    <thead style="background-color: #003B73; color: white;">
                        <tr>
                            <th class="ps-4 py-3" width="30%">Menu Default</th>
                            <th class="py-3" width="40%">Ubah Nama Menjadi</th>
                            <th class="py-3 text-center" width="30%">Tampilkan?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($menu_list as $key => $default_label): 
                            $db_label = isset($settings["menu_{$key}_label"]) ? $settings["menu_{$key}_label"] : trim(str_replace(['--', 'Sub: ', ' (Dropdown)'], '', $default_label));
                            $db_show = isset($settings["menu_{$key}_show"]) ? $settings["menu_{$key}_show"] : '1';
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?php echo $default_label; ?></td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="menu_<?php echo $key; ?>_label" value="<?php echo htmlspecialchars($db_label); ?>" required>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" role="switch" name="menu_<?php echo $key; ?>_show" value="1" <?php echo ($db_show == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor: pointer;">
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Pengaturan Menu
                </button>
            </div>
        </form>
    </div>
</div>