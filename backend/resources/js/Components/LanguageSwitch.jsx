import React from "react";
import { router } from "@inertiajs/react";

export default function LanguageSwitch({
  currentLocale = "fr",
  locales = ["fr", "en"],
  className = "mr-2"
}) {
  const csrf = window.csrf_token;
  const locale = window.current_locale || currentLocale;

  const handleChange = (e) => {
    const value = e.target.value;
    router.post(
      "/lang",
      { locale: value },
      {
        headers: { "X-CSRF-TOKEN": csrf },
        preserveScroll: true,
        onSuccess: () => router.reload({ preserveScroll: true }),
      }
    );
  };

  return (
    <select
      name="locale"
      defaultValue={locale}
      className={`rounded px-2 py-1 text-sm bg-white text-[#3a5a8f] border border-gray-300 focus:outline-none ${className}`}
      aria-label="Changer la langue"
      onChange={handleChange}
    >
      {locales.map((loc) => (
        <option key={loc} value={loc}>
          {loc.toUpperCase()}
        </option>
      ))}
    </select>
  );
}