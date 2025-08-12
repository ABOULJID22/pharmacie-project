import React, { useState, useEffect,useRef } from "react";
import { Link } from "@inertiajs/react";
import LanguageSwitch from "@/Components/LanguageSwitch";

export default function NavBar({ auth, settings }) {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
const [dropdownOpen, setDropdownOpen] = useState(false);
  const dropdownRef = useRef();
  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 50);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  // Close mobile menu on resize (for better UX)
  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth >= 768) setIsMobileMenuOpen(false);
    };
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);


  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setDropdownOpen(false);
      }
    }
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);
  // Génère les initiales si pas de photo
  const getInitials = (user) => {
    if (!user) return "";
    const names = user.name ? user.name.split(" ") : [];
    return names.map((n) => n[0]).join("").toUpperCase().slice(0, 2);
  };

  return (
    <nav
      className={`fixed w-full z-30 top-0 transition-all duration-300 ${
        isScrolled
          ? "bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] shadow-md"
          : "bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] bg-opacity-90"
      }`}
      style={{ WebkitBackdropFilter: "blur(2px)", backdropFilter: "blur(2px)" }}
      role="navigation"
      aria-label="Main navigation"
    >
      <div className="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-2 md:py-3">
        {/* Logo */}
        <Link href="/" className="flex items-center space-x-3 min-w-[120px]">
          <img
            src={settings?.logo ? `/storage/${settings.logo}` : "/images/logbo.png"}
            className="h-auto w-auto"
            alt="Logo Offitrade"
            loading="lazy"
            style={{ maxWidth: 120 }}
          />
          <span className="self-center text-2xl font-semibold whitespace-nowrap text-[#1b2336] sr-only">
            Offitrade
          </span>
        </Link>

        {/* Desktop Navigation */}
        <div className="hidden md:flex items-center space-x-4 lg:space-x-8">
          <Link
            href="/"
            className="text-[#1b2336] hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition"
          >
            Accueil
          </Link>
          <Link
            href="#about"
            className="text-[#1b2336] hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition"
          >
            À propos
          </Link>
          <Link
            href="#services"
            className="text-[#1b2336] hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition"
          >
            Services
          </Link>
          <Link
            href="#contact"
            className="text-[#1b2336] hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition"
          >
            Contact
          </Link>
<div className="flex items-center space-x-2">
  {/* Sélecteur de langue */}
{/* <LanguageSwitch/> */}
</div>



        {auth && auth.user ? (
            <div className="relative ml-4" ref={dropdownRef}>
              <button
                onClick={() => setDropdownOpen((v) => !v)}
                className="flex items-center focus:outline-none"
                aria-haspopup="true"
                aria-expanded={dropdownOpen}
              >
                {/* Avatar image ou initiales */}
                {auth.user.avatar ? (
                  <img
                    src={auth.user.avatar}
                    alt={auth.user.name}
                    className="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover"
                  />
                ) : (
                  <span className="w-9 h-9 flex items-center justify-center rounded-full bg-blue-200 text-blue-800 font-bold text-lg border-2 border-white shadow-sm">
                    {getInitials(auth.user)}
                  </span>
                )}
                <svg
                  className="w-4 h-4 ml-1 text-[#1b2336]"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  viewBox="0 0 24 24"
                >
                </svg>
              </button>
              {/* Dropdown menu */}
              {dropdownOpen && (
                <div className="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                  {auth.user.role === "admin" && (
                    <a
                      href={route('filament.admin.pages.dashboard')}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    >
                      Admin Panel
                    </a>
                  )}
                  <Link
                    href={route("logout")}
                    method="post"
                    as="button"
                    className="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                  >
                    Déconnexion
                  </Link>
                </div>
              )}
            </div>
          ) : (
            <>
              <Link
                href={route("login")}
                className="px-3 py-2 text-sm font-medium text-[#1b2336] border border-white rounded-lg hover:bg-white hover:text-[#3a5a8f] transition"
              >
                Se connecter
              </Link>
              <Link
                href={route("register")}
                className="px-3 py-2 text-sm font-medium text-[#1b2336] bg-[#3a5a8f] rounded-lg hover:bg-[#2b3f61] transition"
              >
                S'inscrire
              </Link>
            </>
          )}
        </div>

        {/* Mobile Menu Button */}
        <button
          onClick={() => setIsMobileMenuOpen((v) => !v)}
          className="inline-flex items-center p-2 w-10 h-10 justify-center text-[#1b2336] rounded-lg md:hidden hover:bg-blue-100 hover:text-[#3a5a8f] focus:outline-none focus:ring-2 focus:ring-blue-200"
          aria-label={isMobileMenuOpen ? "Fermer le menu" : "Ouvrir le menu"}
        >
          <svg
            className={`w-6 h-6 ${isMobileMenuOpen ? "hidden" : "block"}`}
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden={!isMobileMenuOpen}
          >
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 8h16M4 16h16" />
          </svg>
          <svg
            className={`w-6 h-6 ${isMobileMenuOpen ? "block" : "hidden"}`}
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden={isMobileMenuOpen}
          >
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      {/* Mobile Navigation */}
      <div
        className={`md:hidden transition-all duration-300 bg-white/95 shadow-lg ${
          isMobileMenuOpen ? "max-h-[500px] py-2" : "max-h-0 overflow-hidden py-0"
        }`}
        style={{ WebkitBackdropFilter: "blur(2px)", backdropFilter: "blur(2px)" }}
      >
        <div className="flex flex-col space-y-1 px-4">
          <Link
            href="/"
            className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
            onClick={() => setIsMobileMenuOpen(false)}
          >
            Accueil
          </Link>
          <Link
            href="#about"
            className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
            onClick={() => setIsMobileMenuOpen(false)}
          >
            À propos
          </Link>
          <Link
            href="#services"
            className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
            onClick={() => setIsMobileMenuOpen(false)}
          >
            Services
          </Link>
          <Link
            href="#contact"
            className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
            onClick={() => setIsMobileMenuOpen(false)}
          >
            Contact
          </Link>
          {auth && auth.user ? (
            <>
              {auth.user.role === "admin" && (
                <Link
                  href={route("dashboard")}
                  className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  Dashboard
                </Link>
              )}
              <Link
                href={route("profile.edit")}
                className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Profil
              </Link>
              <Link
                href={route("logout")}
                method="post"
                as="button"
                className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Déconnexion
              </Link>
            </>
          ) : (
            <>
              <Link
                href={route("login")}
                className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Se connecter
              </Link>
              <Link
                href={route("register")}
                className="block text-[#3a5a8f] hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium transition"
                onClick={() => setIsMobileMenuOpen(false)}
              >
                S'inscrire
              </Link>
            </>
          )}
        </div>
      </div>
    </nav>
  );
}