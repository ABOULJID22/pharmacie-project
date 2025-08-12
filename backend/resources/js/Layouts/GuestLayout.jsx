import ApplicationLogo from '@/Components/ApplicationLogo';
import NavBar from '@/Layouts/NavBar';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children,setting }) {
    return (
        <div className="relative min-h-screen flex flex-col">
            {/* Background image with blur */}
            <div
                className="absolute inset-0 z-0"
                style={{
                    backgroundImage: "url('/images/img1.jpg')",
                    backgroundSize: "cover",
                    backgroundPosition: "center",
                    filter: "blur(2px)",
                }}
                aria-hidden="true"
            />
            {/* Overlay to darken the background if needed */}
            <div className="absolute inset-0  bg-opacity-60 z-0" aria-hidden="true" />
            
            {/* Content */}
            <div className="relative z-10 flex flex-col min-h-screen">
                <NavBar />
                <div className="flex flex-1 flex-col items-center justify-center pt-8 sm:pt-0">
                    <div>
                        {/* <Link href="/">
                            <ApplicationLogo className="h-20 w-20 fill-current text-gray-500" />
                        </Link> */}
                    </div>
                    <div className="mt-6 w-full overflow-hidden  bg-opacity-90 px-8 py-8 sm:max-w-xl sm:rounded-lg shadow-lg">
                        {children}
                    </div>
                </div>
            </div>

        </div>
    );
}
//bg-gradient-to-br from-blue-100 via-white to-blue-200