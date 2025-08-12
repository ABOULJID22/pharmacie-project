import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => {
                reset('password');
                window.location.href = route('welcome');
            },
        });
    };

    return (
        <GuestLayout>
            <Head title="Connexion" />

            <div className="flex items-center justify-center min-h-screen  px-4 sm:px-6 lg:px-8 py-8"   >
                <div className="w-full space-y-4 bg-gradient-to-br from-blue-100 via-white to-blue-200 shadow-xl rounded-2xl p-10">
                    <div className="text-center">
                        <h2 className="text-3xl font-extrabold text-gray-900">
                            Bienvenue sur <span className="text-indigo-600">Offitrade</span>
                        </h2>
                        <p className="mt-2 text-sm text-gray-600">
                            Connectez-vous à votre compte
                        </p>
                    </div>

                    {status && (
                        <div className="text-green-600 text-sm text-center font-medium">
                            {status}
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-6">
                        <div>
                            <InputLabel htmlFor="email" value="Adresse e-mail" />
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                autoComplete="username"
                                isFocused={true}
                                onChange={(e) => setData('email', e.target.value)}
                            />
                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        <div>
                            <InputLabel htmlFor="password" value="Mot de passe" />
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                autoComplete="current-password"
                                onChange={(e) => setData('password', e.target.value)}
                            />
                            <InputError message={errors.password} className="mt-2" />
                        </div>

                        <div className="flex items-center justify-between">
                            <label className="flex items-center">
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData('remember', e.target.checked)
                                    }
                                />
                                <span className="ml-2 text-sm text-gray-600">
                                    Se souvenir de moi
                                </span>
                            </label>

                            {canResetPassword && (
                                <Link
                                    href={route('password.request')}
                                    className="text-sm text-indigo-600 hover:underline"
                                >
                                    Mot de passe oublié ?
                                </Link>
                            )}
                        </div>

                        <PrimaryButton
                            className="w-full justify-center py-3 rounded-xl text-base font-semibold bg-indigo-600 hover:bg-indigo-700 transition"
                            disabled={processing}
                        >
                            Se connecter
                        </PrimaryButton>
                    </form>

                    <div className="text-center mt-6">
                        <p className="text-sm text-gray-600">
                            Vous n’avez pas de compte ?{' '}
                            <Link
                                href={route('register')}
                                className="text-indigo-600 hover:underline font-medium"
                            >
                                Créez-en un
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
