<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Fitur Hapus Subscriber
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $del = $db->prepare("DELETE FROM subscribers WHERE id = :id");
    $del->execute([':id' => $_GET['id']]);
    echo "<script>alert('Subscriber berhasil dihapus!'); window.location.href='index.php?page=admin_subscriber';</script>";
}

// Ambil data subscriber
$stmt = $db->prepare("SELECT * FROM subscribers ORDER BY id DESC");
$stmt->execute();
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-envelope-open-text fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Daftar Subscriber</h3>
        <p class="text-muted mb-0 small">Email pengunjung yang berlangganan Newsletter.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #005B96;">
                    <tr>
                        <th class="ps-4 py-3 border-0">No</th>
                        <th class="py-3 border-0">Alamat Email</th>
                        <th class="py-3 border-0">Tanggal Berlangganan</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($subscribers)): ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada subscriber.</td></tr>
                    <?php else: ?>
                        <?php $no=1; foreach($subscribers as $sub): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?php echo $no++; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($sub['email']); ?></td>
                            <td class="text-muted small"><?php echo date('d M Y, H:i', strtotime($sub['created_at'])); ?></td>
                            <td class="text-center">
                                <a href="?page=admin_subscriber&action=delete&id=<?php echo $sub['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Hapus email ini dari daftar?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>