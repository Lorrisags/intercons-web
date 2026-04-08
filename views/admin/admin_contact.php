<?php
/* Path File: /views/admin/admin_contact.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Fitur hapus pesan
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $del = $db->prepare("DELETE FROM contact_messages WHERE id = :id");
    $del->execute([':id' => $_GET['id']]);
    echo "<script>alert('Pesan berhasil dihapus!'); window.location.href='index.php?page=admin_contact';</script>";
}

// Ambil semua pesan dari yang paling baru
$stmt = $db->prepare("SELECT * FROM contact_messages ORDER BY created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #dc3545 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Pesan & Permintaan Masuk</h4>
        <p class="text-muted mb-0 small">Daftar permintaan layanan dari calon klien via website.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #dc3545;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Tanggal</th>
                        <th class="py-3 border-0">Nama Instansi / Perusahaan</th>
                        <th class="py-3 border-0">Kebutuhan</th>
                        <th class="py-3 border-0">Detail Permintaan</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($messages)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada pesan masuk.</td></tr>
                    <?php else: ?>
                        <?php foreach($messages as $msg): ?>
                        <tr>
                            <td class="ps-4 py-3 text-muted small">
                                <?php echo date('d M Y, H:i', strtotime($msg['created_at'])); ?>
                            </td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($msg['company_name']); ?></td>
                            <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($msg['service_needed']); ?></span></td>
                            <td class="text-muted small" style="max-width: 300px; white-space: normal;">
                                <?php echo nl2br(htmlspecialchars($msg['details'])); ?>
                            </td>
                            <td class="text-center">
                                <a href="?page=admin_contact&action=delete&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Yakin ingin menghapus pesan ini?');" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>