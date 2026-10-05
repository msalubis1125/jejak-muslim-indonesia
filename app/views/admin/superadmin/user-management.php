<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl text-gray-800">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola hak akses akun Super Administrator dan Takmir Masjid.</p>
    </div>
    <!-- Role Filter Tabs -->
    <div class="flex items-center gap-1.5 bg-gray-100 p-1 rounded-xl text-xs font-medium">
        <a href="<?= BASE_URL ?>/admin/superadmin/users" class="px-3 py-1.5 rounded-lg <?= empty($role_filter) ? 'bg-white text-gray-800 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' ?>">Semua</a>
        <a href="<?= BASE_URL ?>/admin/superadmin/users?role=super_admin" class="px-3 py-1.5 rounded-lg <?= ($role_filter === 'super_admin') ? 'bg-white text-indigo-700 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' ?>">Super Admin</a>
        <a href="<?= BASE_URL ?>/admin/superadmin/users?role=takmir" class="px-3 py-1.5 rounded-lg <?= ($role_filter === 'takmir') ? 'bg-white text-emerald-700 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' ?>">Takmir</a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="py-4 px-6 font-semibold">Pengguna</th>
                    <th class="py-4 px-6 font-semibold">Role</th>
                    <th class="py-4 px-6 font-semibold">Afiliasi Masjid</th>
                    <th class="py-4 px-6 font-semibold text-center">Status</th>
                    <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-400">Tidak ada pengguna yang sesuai filter.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800"><?= htmlspecialchars($u['nama']) ?></div>
                                <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($u['email']) ?></div>
                            </td>
                            <td class="py-4 px-6">
                                <?php if ($u['role'] === 'super_admin'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">Super Admin</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Takmir</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6">
                                <?= !empty($u['nama_masjid']) ? htmlspecialchars($u['nama_masjid']) : '<span class="text-gray-400 italic">Nasional / Tak Terikat</span>' ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <?php if (!empty($u['is_active'])): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <?php if ($u['id'] != (Session::getUser()['id'] ?? 0)): ?>
                                        <!-- Toggle Status -->
                                        <form action="<?= BASE_URL ?>/admin/superadmin/users/toggleActive/<?= $u['id'] ?>" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-lg border <?= !empty($u['is_active']) ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' ?> transition">
                                                <?= !empty($u['is_active']) ? 'Nonaktifkan' : 'Aktifkan' ?>
                                            </button>
                                        </form>

                                        <!-- Reset Password -->
                                        <form action="<?= BASE_URL ?>/admin/superadmin/users/resetPassword/<?= $u['id'] ?>" method="POST" onsubmit="return confirm('Reset password pengguna ini ke password acak sementara?');">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-100 transition" title="Reset Password">
                                                Reset Sandi
                                            </button>
                                        </form>

                                        <!-- Login As Takmir -->
                                        <?php if ($u['role'] === 'takmir'): ?>
                                            <form action="<?= BASE_URL ?>/admin/superadmin/users/loginAs/<?= $u['id'] ?>" method="POST">
                                                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-100 transition" title="Impersonate Takmir">
                                                    Login Sebagai
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 italic">Akun Anda</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
