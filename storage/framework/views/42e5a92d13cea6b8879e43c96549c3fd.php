<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AIX Command & Portal</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <a href="<?php echo e(route('public.explore')); ?>" class="flex items-center gap-2 mb-8">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-rose-500 to-orange-400"></div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">Platform AIX</span>
                </a>
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Masuk ke akun Anda</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Akses Dual-Antarmuka: Donatur Publik & Pusat Komando
                </p>
            </div>

            <div class="mt-8">
                <div class="mt-6">
                    <form action="<?php echo e(route('login.post')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full appearance-none rounded-xl border border-gray-300 px-4 py-3 placeholder-gray-400 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-rose-500 sm:text-sm transition-colors" placeholder="admin@aix.gov / donor@example.com">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full appearance-none rounded-xl border border-gray-300 px-4 py-3 placeholder-gray-400 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-rose-500 sm:text-sm transition-colors" placeholder="kata sandi">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                            </div>

                            <div class="text-sm">
                                <a href="#" class="font-medium text-rose-600 hover:text-rose-500">Lupa kata sandi Anda?</a>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-xl border border-transparent bg-black hover:bg-gray-800 py-3.5 px-4 text-sm font-semibold text-white shadow-lg shadow-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all">
                                Masuk Aman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1549487959-1e18cd665b1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" alt="Operasi Pusat Komando">
        <div class="absolute inset-0 bg-rose-900/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent flex flex-col justify-end p-20">
            <h2 class="text-4xl font-bold text-white mb-4">Mitigasi Risiko Proaktif</h2>
            <p class="text-xl text-gray-200 max-w-2xl font-light">Menerapkan intervensi algoritmik untuk menetralisir ancaman lingkungan, ekonomi, dan sosial sebelum berkembang menjadi krisis multi-tingkat yang tidak dapat diubah.</p>
        </div>
    </div>
</body>
</html><?php /**PATH /Users/ajspryn/Project/aix/resources/views/auth/login.blade.php ENDPATH**/ ?>