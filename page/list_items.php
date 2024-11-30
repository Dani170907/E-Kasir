<h2>Daftar Barang</h2>

<div class="header-actions">
    <a class="btn btn-primary btn-md" href="?p=add_item">
        <span class="glyphicon glyphicon-plus"></span>
        Tambah
    </a>

    <form method="get" class="form-inline search-form">
        <input type="hidden" name="p" value="list_items">
        <input placeholder="Cari di sini" type="text" name="search" class="form-control" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="btn btn-sm btn-primary">
            <span class="glyphicon glyphicon-search"></span> Cari
        </button>
    </form>
</div>

<table class="table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Tanggal Ditambahkan</th>
            <th>Dirubah</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Ambil parameter pencarian
        @$search = $_GET['search'];
        $searchQuery = "";
        if (!empty($search)) {
            $searchQuery .= " AND productName LIKE '%" . mysqli_real_escape_string($connection, $search) . "%'";
        }

        // Konfigurasi pagination
        $pagination = 5;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = $page > 1 ? ($page - 1) * $pagination : 0;

        // Query utama dengan pagination dan pencarian
        $sql = "SELECT * FROM products WHERE 1=1 $searchQuery LIMIT $start, $pagination";
        $query = mysqli_query($connection, $sql);
        $check = mysqli_num_rows($query);

        // Query total data untuk pagination
        $sqlTotal = "SELECT COUNT(*) as total FROM products WHERE 1=1 $searchQuery";
        $queryTotal = mysqli_query($connection, $sqlTotal);
        $dataTotal = mysqli_fetch_assoc($queryTotal);
        $total = $dataTotal['total'];
        $numOfPages = ceil($total / $pagination);

        $no = $start + 1;
        if ($check > 0) :
            while ($data = mysqli_fetch_array($query)) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data['productName']) ?></td>
            <td><?= htmlspecialchars($data['category']) ?></td>
            <td><?= "Rp " . number_format($data['price'], 0, ',', '.'); ?></td>
            <td><?= htmlspecialchars($data['createdAt']) ?></td>
            <td><?= htmlspecialchars($data['updatedAt']) ?></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $data['productId'] ?>)">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
                |
                <a class="btn btn-info btn-sm" href="?p=edit_item&productId=<?= $data['productId'] ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php else : ?>
        <tr>
            <td colspan="7">Tidak ada data!</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="float-left">
    Jumlah : <?= $total ?>
</div>

<div style="float: right;">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="<?= ($page == 1) ? 'disabled' : '' ?>">
                <a href="?p=list_items&page=<?= max(1, $page - 1) ?>&search=<?= urlencode($search) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $numOfPages; $i++) : ?>
            <li class="<?= ($i == $page) ? 'active' : '' ?>">
                <a href="?p=list_items&page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="<?= ($page == $numOfPages) ? 'disabled' : '' ?>">
                <a href="?p=list_items&page=<?= min($numOfPages, $page + 1) ?>&search=<?= urlencode($search) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<script>
    function confirmDelete(productId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data tidak bisa dikembalikan setelah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman delete dengan parameter productId
                window.location.href = `page/delete_item.php?productId=${productId}`;
            }
        });
    }
</script>
