import React, { useEffect,useRef, useState } from "react";

import NavBar from "../Layouts/NavBar";
import { motion } from "framer-motion";
import { Head, usePage } from "@inertiajs/react";
import { useForm } from "@inertiajs/react";

export default function Welcome({ auth, settings, faqs, teams }) {
/* const { settings } = usePage().props;
 */ const [contactInfo, setContactInfo] = useState([]);

  const [messages, setMessages] = useState([]);
 
  useEffect(() => {
    fetch("/api/contact") // Assure-toi que cette route existe côté Laravel
      .then((response) => response.json())
      .then((data) => setContactInfo(data))
      .catch((error) => console.error("Error fetching contact info:", error));
  }, []);
/*   const [faqs, setFaqs] = useState([]);

  // Récupération des 
  useEffect(() => {
    fetch("/api/faqs") // Assure-toi que cette route existe côté Laravel
      .then((response) => response.json())
      .then((data) => setFaqs(data))
      .catch((error) => console.error("Error fetching contact info:", error));
  }, []);
 */

  const contactInput = useRef();
  const { data, setData, post, reset, processing, errors } = useForm({
    name: "",
    email: "",
    phone: "",
    function: "",
    message: "",
  });
  
  const sendMessage = (e) => {
    e.preventDefault();

    post(route("contact.store"), {
      onSuccess: () => {
        reset();
        alert("Your message has been sent successfully!");
      },
      onError: (errors) => {
        if (errors.phone) {
          contactInput.current.focus();
        }
      },
    });
  };


  return (
    <>
      <NavBar auth={auth} settings={settings} />


<section className="relative min-h-[50vh] md:min-h-[70vh] flex flex-col justify-end bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] overflow-hidden">
  <div className="container mx-auto flex flex-col md:flex-row items-center justify-between py-12 md:py-20 px-4 md:px-8 relative z-10 w-full">
    
    {/* Texte gauche */}
    <div
      className="w-full md:w-1/2 text-center md:text-left space-y-6 z-20"
      data-aos="fade-right"
      data-aos-duration="1000"
    >
      <h1 className="text-2xl sm:text-3xl md:text-5xl font-extrabold leading-tight mb-2 text-white">
        Bienvenue sur votre plateforme <span className="text-[#1b2336]">Offitrade</span>
      </h1>
      <p className="text-base sm:text-lg md:text-xl text-white/90 mb-6">
        Offitrade, confiez vos opérations trade et concentrez-vous pleinement sur votre cœur de métier.
      </p>
      <button className="bg-[#1b2336] text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-[#283752] transition-transform duration-300 hover:scale-105">
        DEMARRER MAINTENANT
      </button>
    </div>

    {/* Image droite (masquée sur mobile) */}
    <div
      className="w-full md:w-1/2 hidden md:flex justify-center md:justify-end items-end relative z-20"
      data-aos="fade-left"
      data-aos-duration="1000"
    >
      <img
        src="/images/dame.svg"
        alt="Illustration Offitrade"
        className="max-w-[90%] md:max-w-[520px] lg:max-w-[600px] drop-shadow-2xl"
        style={{
          position: 'relative',
          bottom: '-40px',
        }}
        loading="lazy"
      />
    </div>
  </div>

  {/* Vague décorative */}
  <div className="relative -mt-8 md:-mt-16 z-10">
    <svg
      viewBox="0 0 1428 174"
      xmlns="http://www.w3.org/2000/svg"
      className="w-full h-16 md:h-28"
      preserveAspectRatio="none"
    >
      <g stroke="none" strokeWidth="1" fill="none" fillRule="evenodd">
        <g transform="translate(-2, 44)" fill="#FFFFFF" fillRule="nonzero">
          <path
            d="M0,0 C90.7,0.9 147.9,27.1 291.9,59.9 C387.9,81.7 543.6,89.3 759,82.7 C469.3,156.2 216.3,153.6 0,74.9"
            opacity="0.1"
          ></path>
          <path
            d="M100,104.7 C277.4,72.2 426.1,52.5 546.2,45.5 C666.2,38.6 810.5,41.7 979,55 C931,56.1 810.3,74.8 616.7,111.2 C423.1,147.6 250.8,145.4 100,104.7 Z"
            opacity="0.1"
          ></path>
          <path
            d="M1046,51.6 C1130.8,29.3 1279.0,17.6 1439,40.1 L1439,120 C1271.1,77.9 1140.1,55.1 1046,51.6 Z"
            opacity="0.2"
          ></path>
        </g>
        <g transform="translate(-4, 76)" fill="#FFFFFF" fillRule="nonzero">
          <path
            d="M0.4,34 C57,53.1 98.2,65.8 123.8,71.8 C181.4,85.4 234.2,90.2 272,93.4 C311.3,96.7 396.6,95.8 461,91.6 C486.7,90 518.7,86.3 556.9,80.7 C595.7,74.5 622.3,70 636.7,66.9 C663.9,61.3 712.5,49.5 727.6,46.1 C780.4,34.3 818.8,22.5 856.3,15.9 C922.6,4.1 955.6,2.5 1011.1,0.4 C1060.7,1.4 1097.3,3.1 1121.2,5.3 C1161.7,9.2 1208.6,17.8 1235.4,22.3 C1285.8,30.7 1354.3,47.4 1440.8,72.3 L1441.1,104.3 L1.1,104 L0.4,34 Z"
          ></path>
        </g>
      </g>
    </svg>
  </div>
</section>


{/* Custom Animations */}



{/* about  */}

    <section className="about-us px-4 py-8 md:py-24 lg:py-32 bg-white" id="about">
      <div className="container mx-auto max-w-7xl">
        <div className="flex flex-col lg:flex-row items-center justify-between gap-12">
          
          {/* Image Grid */}
          <motion.div
            className="lg:w-6/12 relative"
            initial={{ opacity: 0, x: -50 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <div className="grid grid-cols-2 gap-4 w-full max-w-lg mx-auto">
              <div className="grid grid-rows-[40%_60%] gap-4">
                <img
                  src="/images/img1.jpg"
                  className="w-full h-full object-cover rounded-xl shadow-lg"
                  alt="Bureau moderne"
                />
                <img
                  src="/images/img2.jpg"
                  className="w-full h-full object-cover rounded-xl shadow-lg"
                  alt="Équipe au travail"
                />
              </div>
              <div className="grid grid-rows-[60%_40%] gap-4">
                <img
                  src="/images/img3.jpg"
                  className="w-full h-full object-cover rounded-xl shadow-lg"
                  alt="Analyse des performances"
                />
                <img
                  src="/images/img1.jpg"
                  className="w-full h-full object-cover rounded-xl shadow-lg"
                  alt="Salle de réunion"
                />
              </div>
            </div>
          </motion.div>

          {/* Text Content */}
          <motion.div
            className="lg:w-6/12 lg:pl-10"
            initial={{ opacity: 0, x: 50 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
              Notre Histoire d'Excellence chez <span className="text-[#3a5a8f]">Offitrade</span>
            </h2>
            <p className="text-gray-600 text-base leading-relaxed mb-4">
              Chez Offitrade, nous sommes spécialisés dans l'optimisation et la gestion de vos opérations commerciales. De la réalisation d'audits jusqu'au paiement, nous vous aidons à maximiser vos marges et à améliorer votre rentabilité.
            </p>
            <p className="text-gray-600 text-base leading-relaxed">
              En nous confiant la mise en place de vos opérations Trade, vous pouvez vous recentrer sur votre cœur de métier. Offitrade devient ainsi votre allié stratégique, vous permettant de simplifier vos processus et d’optimiser votre temps et vos ressources.
            </p>

            {/* Stats */}
            <div className="flex flex-col sm:flex-row mt-8 gap-6">
              <div className="flex items-center space-x-4">
                <svg className="w-12 h-12 text-[#3a5a8f]" fill="none" stroke="currentColor" strokeWidth="2"
                  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path strokeLinecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                </svg>
                <div>
                  <h3 className="font-semibold text-lg text-gray-800">90k+ Clients</h3>
                  <p className="text-gray-500 text-sm">Faites confiance à notre service</p>
                </div>
              </div>

              <div className="flex items-center space-x-4">
                <svg className="w-12 h-12 text-[#3a5a8f]" fill="none" stroke="currentColor" strokeWidth="2"
                  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M14.079 6.839a3 3 0 0 0-4.255.1M13 20h1.083A3.916 3.916 0 0 0 18 16.083V9A6 6 0 1 0 6 9v7m7 4v-1a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4v-6H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1v-6Z" />
                </svg>
                <div>
                  <h3 className="font-semibold text-lg text-gray-800">100+ Services</h3>
                  <p className="text-gray-500 text-sm">Prêts à vous servir</p>
                </div>
              </div>
            </div>
          </motion.div>
        </div>
      </div>
    </section>


      {/* services */}
<section
  className="bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] text-white py-16"
  id="services"
>
  <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    {/* Title */}
    <motion.h1
      className="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-10 leading-snug"
      initial={{ opacity: 0, y: -50 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.8 }}
    >
      Offitrade : Optimisez votre gestion en pharmacie
    </motion.h1>

    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
      {/* Text Section */}
      <motion.div
        className="leading-relaxed text-base md:text-lg"
        initial={{ opacity: 0, x: -50 }}
        animate={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.8 }}
      >
        <p className="mb-4">
          En début d'année, les pharmacies cherchent à maximiser les remises et
          offres, mais après cette période intense, la gestion des mises en
          avant devient complexe pour les équipes. Offitrade propose une
          solution clé en main pour simplifier l'organisation, la planification
          et le suivi des paiements.
        </p>
        <p className="mb-6">
          L'accompagnement commence par des audits personnalisés, suivi par un
          calendrier trade annuel. La mise en avant des produits en Tête de
          Gondole (TG) est planifiée sur six mois avec rappels et objectifs. Des
          rendez-vous trimestriels garantissent le suivi des paiements.
        </p>

        {/* Features */}
        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
          {[
            { icon: '⏱️', title: 'Gain de temps' },
            { icon: '📈', title: 'Booster le Sell Out' },
            { icon: '🤝', title: 'Accompagnement personnalisé' },
            { icon: '💰', title: 'Trésorerie stabilisée' },
          ].map((feature, i) => (
            <motion.div
              key={i}
              className="flex items-start gap-3"
              whileHover={{ scale: 1.05 }}
              transition={{ duration: 0.3 }}
            >
              <div className="text-3xl">{feature.icon}</div>
              <h3 className="text-xl font-semibold">{feature.title}</h3>
            </motion.div>
          ))}
        </div>
      </motion.div>

      {/* Video Section */}
      <motion.div
        className="flex justify-center items-center"
        initial={{ opacity: 0, x: 50 }}
        animate={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.8 }}
      >
        <video
          className="w-full h-64 md:h-96 rounded-xl shadow-lg"
          autoPlay
          muted
          playsInline
          loop
          controls={false}
          title="Présentation vidéo Offitrade"
        >
          <source
            src={
              settings?.video_service
                ? `/storage/${settings.video_service}`
                : '/video/269264_tiny.mp4'
            }
            type="video/mp4"
          />
          Votre navigateur ne supporte pas la lecture vidéo.
        </video>
      </motion.div>
    </div>
  </div>
</section>



{/* contact */}
<section className="bg-white text-gray-800 py-16" id="contact">
  <div className=" mx-auto px-4">
    <div className="text-center mb-12">
      <h1 className="text-4xl font-bold mb-4">Contactez-nous</h1>
      <p className="text-lg">
        Vous avez des questions ou besoin d'assistance ? N'hésitez pas à nous contacter.
      </p>
    </div>

    <div className="flex flex-col lg:flex-row lg:justify-between gap-8">
      {/* Colonne gauche : Informations de contact */}
      <div className="lg:w-1/2">
        <h2 className="text-2xl font-bold mb-6">CONTACTEZ-NOUS</h2>
        <p className="text-base text-gray-600 mb-6">
          Chez Offitrade, nous optimisons vos opérations commerciales, des audits jusqu'au paiement,
          pour maximiser vos marges et améliorer votre rentabilité. En nous confiant la gestion de
          vos opérations Trade, vous pouvez vous concentrer sur votre cœur de métier, tout en
          simplifiant vos processus et en optimisant vos ressources.
        </p>
        <div  className="mb-6 px-4 py-2">
        {/* Adresse */}
        <div className="flex items-center mb-6">
          <svg className="w-8 h-8 text-[#3a5a8f] mr-4" fill="currentColor" viewBox="0 0 32 32">
            <path d="M30.6 11.8L17.7 3.5c-1.05-.65-2.4-.65-3.4 0L1.4 11.8c-.5.35-.65 1.05-.35 1.55.35.5 1.05.65 1.55.35l.85-.55v12.65C3.45 27.55 4.85 28.95 6.6 28.95h18.8c1.75 0 3.15-1.4 3.15-3.15V13.15l.85.55c.2.1.4.2.6.2.35 0 .75-.2.95-.5.35-.55.2-1.25-.35-1.6zM13.35 26.75V18.5c0-.5.4-.9.9-.9h3.5c.5 0 .9.4.9.9v8.25h-5.3zM26.3 25.8c0 .5-.4.9-.9.9h-4.5V18.5c0-1.7-1.4-3.1-3.1-3.1h-3.5c-1.7 0-3.1 1.4-3.1 3.1v8.25H6.7c-.5 0-.9-.4-.9-.9V11.7l9.7-6.3c.3-.2.7-.2 1 0l9.8 6.3V25.8z" />
          </svg>
          <div>
            <h4 className="text-lg font-semibold">Notre adresse</h4>
            <p>{settings?.address || "Adresse non disponible"}</p>
          </div>
        </div>

        {/* Téléphone */}
        <div className="flex items-center mb-6">
          <svg className="w-8 h-8 text-[#3a5a8f] mr-4" fill="currentColor" viewBox="0 0 32 32">
            <path d="M24.3 31.15c-1.35 0-2.9-.35-4.6-1-3.4-1.35-7.15-3.95-10.5-7.3S3.25 15.75 1.9 12.3C.4 8.6.55 5.55 2.3 3.85l4.2-2.5c1.05-.6 2.4-.3 3.1.7l2.95 4.4c.7 1.05.4 2.45-.6 3.15l-1.8 1.25c1.3 2.1 5 7.25 10.9 10.95l1.1-1.6c.85-1.2 2.2-1.55 3.3-.8l4.4 2.95c1 .7 1.3 2.05.7 3.1l-2.5 4.2c-.05.1-.1.15-.15.2-.9.95-2.2 1.45-3.8 1.45z" />
          </svg>
          <div>
            <h4 className="text-lg font-semibold">Téléphone</h4>
            <p>{settings?.telephone || "Numéro non disponible"}</p>
          </div>
        </div>

        {/* Email */}
        <div className="flex items-center mb-6">
          <svg
            width="32"
            height="32"
            viewBox="0 0 32 32"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            className="w-8 h-8 text-[#3a5a8f] mr-4"
            >
            <path
                d="M28 4.7998H3.99998C2.29998 4.7998 0.849976 6.1998 0.849976 7.9498V24.1498C0.849976 25.8498 2.24998 27.2998 3.99998 27.2998H28C29.7 27.2998 31.15 25.8998 31.15 24.1498V7.8998C31.15 6.1998 29.7 4.7998 28 4.7998ZM28 7.0498C28.05 7.0498 28.1 7.0498 28.15 7.0498L16 14.8498L3.84998 7.0498C3.89998 7.0498 3.94998 7.0498 3.99998 7.0498H28ZM28 24.9498H3.99998C3.49998 24.9498 3.09998 24.5498 3.09998 24.0498V9.2498L14.8 16.7498C15.15 16.9998 15.55 17.0998 15.95 17.0998C16.35 17.0998 16.75 16.9998 17.1 16.7498L28.8 9.2498V24.0998C28.9 24.5998 28.5 24.9498 28 24.9498Z"
                fill="currentColor"
                />
            </svg>
          <div>
            <h4 className="text-lg font-semibold">Email</h4>
            <p>{settings?.email || "Email non disponible"}</p>
          </div>

        </div>   

         </div> 
        {/* Horaires */}
      
      </div>
      


      {/* Colonne droite : Formulaire de contact */}
      <div className="lg:w-1/2 bg-gray-50 p-6 rounded-lg shadow-lg">
         {messages && (
      <p className="text-green-500 text-sm">{messages}</p>
    )}
        <form className="space-y-4" onSubmit={sendMessage}>
          <div>
            <label className="block text-gray-700 font-medium">Nom</label>
            <input
              type="text"
              id="name"
             value={data.name}
             onChange={(e) => setData("name", e.target.value)}
             required
              placeholder="Votre nom"
              className="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
               {errors.name && (
                      <p className="text-red-500 text-sm mt-1">
                        {errors.name}
                      </p>
                    )}
          </div>
          <div>
            <label className="block text-gray-700 font-medium">Email</label>
            <input
              type="email"
              id="email"
              value={data.email}
              onChange={(e) => setData("email", e.target.value)}

              placeholder="Votre email"
              className="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            {errors.email && (
                      <p className="text-red-500 text-sm mt-1">
                        {errors.email}
                      </p>
                    )}
          </div>
        <div>
        <label className="block text-gray-700 font-medium">Téléphone </label>
        <input
            type="tel"
            id="phone"
            value={data.phone}
            onChange={(e) => setData("phone", e.target.value)}
            placeholder="numéro de téléphone"
            className="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
          {errors.phone && (
                <p className="text-red-500 text-sm mt-1">
                {errors.phone}
                </p>
            )}
        </div>
         <div >
            <label
                htmlFor="function"
                className="block text-sm font-medium text-gray-600"
            >
                Sélectionnez votre fonction
            </label>
            <select
                id="function"
                required
                value={data.function}
                onChange={(e) => setData("function", e.target.value)}
                className="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="" disabled>
                Choisissez votre fonction
                </option>
                <option value="acheteur">Acheteur</option>
                <option value="pharmacien-futur">Pharmacien Futur</option>
                <option value="pharmacien-titulaire">
                Pharmacien Titulaire
                </option>
            </select>
            {errors.function && (
                <p className="text-red-500 text-sm mt-1">
                {errors.function}
                </p>
            )}
        </div>

          <div>
            <label className="block text-gray-700 font-medium">Message</label>
            <textarea
              id="message"
              required
              name="message"
              rows="5"
              value={data.message}
              onChange={(e) => setData("message", e.target.value)}
              placeholder="Votre message"
              className="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
            {errors.message && (
                      <p className="text-red-500 text-sm mt-1">
                        {errors.message}
                      </p>
             )}
          </div>
          <button
            /* ref={contactInput} */
            type="submit"
            className="w-full bg-[#3a5a8f] text-white py-2 rounded-md hover:bg-[#a1b6d8] transition"
            disabled={processing}
          >
            Envoyer
        {processing ? "Envoi en cours..." : "Envoyer le message"}               
        
           </button>
          
        </form>
      </div>
    </div>
  </div>
</section>






{/* equipe  */}
 {teams && teams.length == 0 && teams.map((team, idx) => (
<section className="bg-gray-50 py-20" id="team" key={idx}>
  <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div className="text-center mb-16">
      <h2 className="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
        Notre Équipe d’Experts
      </h2>
      <p className="text-lg text-gray-600 max-w-2xl mx-auto">
        Découvrez les professionnels passionnés qui font la force d’Offitrade. Notre équipe pluridisciplinaire met son expertise au service de votre réussite, avec un accompagnement personnalisé et une exigence d’excellence.
      </p>
    </div>
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
      {/* Hamza */}
      <div className="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center group hover:shadow-2xl transition">
        <img
          src="/images/img1.jpg"
          alt="Dr. Hamza"
          className="w-28 h-28 rounded-full object-cover border-4 border-blue-100 group-hover:scale-105 transition"
        />
        <h3 className="mt-5 text-xl font-bold text-gray-900">Dr. Hamza</h3>
        <p className="text-blue-700 font-medium mb-2">Pharmacien Responsable</p>
        <p className="text-gray-600 text-sm mb-4">
          Expert en pharmacologie clinique, garant de la qualité et de la sécurité des traitements délivrés.
        </p>
        <div className="flex space-x-3">
          <a href="mailto:hamza@offitrade.com" className="text-gray-400 hover:text-blue-600" aria-label="Email">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path></svg>
          </a>
          <a href="https://linkedin.com/" target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-blue-600" aria-label="LinkedIn">
            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/></svg>
          </a>
        </div>
      </div>
      {/* Abir */}
      <div className="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center group hover:shadow-2xl transition">
        <img
          src="/images/img2.jpg"
          alt="Abir"
          className="w-28 h-28 rounded-full object-cover border-4 border-blue-100 group-hover:scale-105 transition"
        />
        <h3 className="mt-5 text-xl font-bold text-gray-900">Abir</h3>
        <p className="text-blue-700 font-medium mb-2">Préparatrice en Pharmacie</p>
        <p className="text-gray-600 text-sm mb-4">
          Assure la préparation, le contrôle et la délivrance des prescriptions avec précision.
        </p>
        <div className="flex space-x-3">
          <a href="mailto:abir@offitrade.com" className="text-gray-400 hover:text-blue-600" aria-label="Email">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path></svg>
          </a>
          <a href="https://linkedin.com/" target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-blue-600" aria-label="LinkedIn">
            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/></svg>
          </a>
        </div>
      </div>
      {/* Charlotte */}
      <div className="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center group hover:shadow-2xl transition">
        <img
          src="/images/img3.jpg"
          alt="Charlotte"
          className="w-28 h-28 rounded-full object-cover border-4 border-blue-100 group-hover:scale-105 transition"
        />
        <h3 className="mt-5 text-xl font-bold text-gray-900">Charlotte</h3>
        <p className="text-blue-700 font-medium mb-2">Conseillère Santé</p>
        <p className="text-gray-600 text-sm mb-4">
          Accompagne les patients dans le choix de produits de santé et bien-être adaptés.
        </p>
        <div className="flex space-x-3">
          <a href="mailto:charlotte@offitrade.com" className="text-gray-400 hover:text-blue-600" aria-label="Email">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path></svg>
          </a>
          <a href="https://linkedin.com/" target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-blue-600" aria-label="LinkedIn">
            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/></svg>
          </a>
        </div>
      </div>
      {/* Julia */}
      <div className="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center group hover:shadow-2xl transition">
        <img
          src="/images/img1.jpg"
          alt="Julia"
          className="w-28 h-28 rounded-full object-cover border-4 border-blue-100 group-hover:scale-105 transition"
        />
        <h3 className="mt-5 text-xl font-bold text-gray-900">Julia</h3>
        <p className="text-blue-700 font-medium mb-2">Gestionnaire de Stock</p>
        <p className="text-gray-600 text-sm mb-4">
          Supervise les approvisionnements et la traçabilité des produits pharmaceutiques.
        </p>
        <div className="flex space-x-3">
          <a href="mailto:julia@offitrade.com" className="text-gray-400 hover:text-blue-600" aria-label="Email">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path></svg>
          </a>
          <a href="https://linkedin.com/" target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-blue-600" aria-label="LinkedIn">
            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/></svg>
          </a>
        </div>
      </div>
    </div>
   
  </div>
</section>
))}

<section className="bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] py-20  shadow-lg"  id="team">
  <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div className="text-center mb-16">
      <h2 className="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
        Notre Équipe d’Experts
      </h2>
      <p className="text-lg text-gray-100  mx-auto">
        Découvrez les professionnels passionnés qui font la force d’Offitrade. Notre équipe pluridisciplinaire met son expertise au service de votre réussite, avec un accompagnement personnalisé et une exigence d’excellence.
      </p>
    </div>
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

      {teams && teams.length > 0 && teams.map((team, idx) => (
    <div key={idx} className="bg-white rounded-2xl shadow-[0_8px_32px_0_rgba(58,90,143,0.18)] p-8 flex flex-col items-center group hover:shadow-[0_12px_40px_0_rgba(161,182,216,0.25)] transition">    <img
      src={`/storage/${team.photo_team}`}
      alt={team.name}
      className="w-28 h-28 rounded-full object-cover border-4 border-blue-100 group-hover:scale-105 transition"
    />
    <h3 className="mt-5 text-xl font-bold text-gray-900">{team.name}</h3>
    <p className="text-blue-700 font-medium mb-2">{team.role}</p>
    <p className="text-gray-600 text-sm mb-4">{team.description}</p>
    <div className="flex space-x-3">
      {team.email && (
        <a href={`mailto:${team.email}`} className="text-gray-400 hover:text-blue-600" aria-label="Email">
          <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path>
          </svg>
        </a>
      )}
      {team.linkedin && (
        <a href={team.linkedin} target="_blank" rel="noopener noreferrer" className="text-gray-400 hover:text-blue-600" aria-label="LinkedIn">
          <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/>
          </svg>
        </a>
      )}
    </div>
  </div>
))}
     
    </div>
   
  </div>
</section>

{/* faq */}
{/* faq */}
<section className="bg-white py-20">
  <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 className="text-3xl font-bold text-gray-900 text-center mb-6">Questions Fréquentes</h2>
    <p className="text-center text-gray-600 mb-12  mx-auto">
      Retrouvez ici les réponses aux questions les plus courantes concernant nos services pharmaceutiques.
    </p>
    <div className="space-y-6">
      {faqs && faqs.length == 0 ? (
        <section className="bg-white py-20">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 className="text-3xl font-bold text-gray-900 text-center mb-6">Questions Fréquentes</h2>
            <p className="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
              Retrouvez ici les réponses aux questions les plus courantes concernant nos services pharmaceutiques.
            </p>

            <div className="space-y-6">
              {/* FAQ Item 1 */}
              <details className="group border-b pb-4">
                <summary className="flex justify-between items-center cursor-pointer text-gray-900 font-medium text-lg">
                  <span>Quels sont les horaires d'ouverture de votre pharmacie ?</span>
                  <svg
                    className="w-5 h-5 transition-transform group-open:rotate-180"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                  </svg>
                </summary>
                <p className="mt-2 text-gray-600 text-sm">
                  Nous sommes ouverts du lundi au samedi de 8h30 à 20h00, et le dimanche de 9h00 à 13h00.
                </p>
              </details>

              {/* FAQ Item 2 */}
              <details className="group border-b pb-4">
                <summary className="flex justify-between items-center cursor-pointer text-gray-900 font-medium text-lg">
                  <span>Proposez-vous un service de livraison de médicaments ?</span>
                  <svg
                    className="w-5 h-5 transition-transform group-open:rotate-180"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                  </svg>
                </summary>
                <p className="mt-2 text-gray-600 text-sm">
                  Oui, nous proposons un service de livraison pour les patients ayant une ordonnance. Contactez-nous pour en savoir plus.
                </p>
              </details>

              {/* FAQ Item 3 */}
              <details className="group border-b pb-4">
                <summary className="flex justify-between items-center cursor-pointer text-gray-900 font-medium text-lg">
                  <span>Acceptez-vous les ordonnances électroniques ?</span>
                  <svg
                    className="w-5 h-5 transition-transform group-open:rotate-180"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                  </svg>
                </summary>
                <p className="mt-2 text-gray-600 text-sm">
                  Tout à fait. Nous acceptons les ordonnances électroniques transmises par email ou via une application de santé approuvée.
                </p>
              </details>

              {/* FAQ Item 4 */}
              <details className="group border-b pb-4">
                <summary className="flex justify-between items-center cursor-pointer text-gray-900 font-medium text-lg">
                  <span>Vos conseils sont-ils personnalisés ?</span>
                  <svg
                    className="w-5 h-5 transition-transform group-open:rotate-180"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                  </svg>
                </summary>
                <p className="mt-2 text-gray-600 text-sm">
                  Absolument. Nos pharmaciens prennent le temps d'échanger avec chaque patient afin d'offrir un accompagnement adapté à son état de santé.
                </p>
              </details>
            </div>
          </div>
        </section>
      ) : null}
   
    
{faqs && faqs.length > 0 && faqs.map((faq, idx) => (
  <details className="group border-b pb-4" key={idx}>
    <summary className="flex justify-between items-center cursor-pointer text-gray-900 font-medium text-lg">
      <span>{faq.question}</span>
      <svg
        className="w-5 h-5 transition-transform group-open:rotate-180"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
      </svg>
    </summary>
    <p className="mt-2 text-gray-600 text-sm">
      {faq.reponse}
    </p>
  </details>
))}
      
    </div>
  </div>
</section>


   {/* Features Section */}
<section className="bg-white py-16">
  <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2
      className="text-4xl font-extrabold text-center text-gray-900 mb-12"
      data-aos="fade-up"
      data-aos-duration="1000"
    >
      Pourquoi nous choisir ?
    </h2>

    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
      {/* Carte 1 */}
      <div
        className="bg-gray-100 p-6 rounded-lg shadow-md text-center hover:shadow-xl transition duration-300 transform hover:scale-105"
        data-aos="zoom-in"
        data-aos-duration="1000"
      >
        <svg
          className="w-16 h-16 mx-auto mb-4 text-green-500"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <h3 className="text-xl font-semibold mb-2 text-gray-800">Haute Qualité</h3>
        <p className="text-gray-600">
          Nous offrons des services de première qualité pour garantir votre succès.
        </p>
      </div>

      {/* Carte 2 */}
      <div
        className="bg-gray-100 p-6 rounded-lg shadow-md text-center hover:shadow-xl transition duration-300 transform hover:scale-105"
        data-aos="zoom-in"
        data-aos-duration="1000"
        data-aos-delay="200"
      >
        <svg
          className="w-16 h-16 mx-auto mb-4 text-blue-500"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M3 10h11M9 21V3m0 0L3 10m6-7l6 7"
          />
        </svg>
        <h3 className="text-xl font-semibold mb-2 text-gray-800">Outils Innovants</h3>
        <p className="text-gray-600">
          Restez en avance grâce à notre technologie de pointe.
        </p>
      </div>

      {/* Carte 3 */}
      <div
        className="bg-gray-100 p-6 rounded-lg shadow-md text-center hover:shadow-xl transition duration-300 transform hover:scale-105"
        data-aos="zoom-in"
        data-aos-duration="1000"
        data-aos-delay="400"
      >
        <svg
          className="w-16 h-16 mx-auto mb-4 text-yellow-500"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4m4-4h4m-16 0H4"
          />
        </svg>
        <h3 className="text-xl font-semibold mb-2 text-gray-800">Support 24/7</h3>
        <p className="text-gray-600">
          Notre équipe est là pour vous aider à tout moment, partout.
        </p>
      </div>
    </div>
  </div>
</section>

      {/* Footer Section */}
<footer className="bg-gradient-to-r from-[#3a5a8f] to-[#a1b6d8] text-gray-300 pt-14 pb-8 mt-16">
  <div className="max-w-7xl mx-auto px-6 lg:px-8">
    <div className="grid grid-cols-1 md:grid-cols-4 gap-10 border-b border-gray-700 pb-10">
      
      {/* Brand & Description */}
  <div >
  <img
   src={settings?.logo ? `/storage/${settings.logo}` : "/images/logo.png"}
    alt="Offitrade Logo"
    className="h-10 mb-4"
  />
    <p className="text-sm mt-2 text-gray-400">
      Optimisez vos opérations commerciales grâce à une solution intelligente et efficace.
    </p>
  </div>


      {/* Navigation */}
      <div>
        <h4 className="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Navigation</h4>
        <ul className="space-y-2 text-sm">
          <li><a href="/" className="hover:text-white transition">Accueil</a></li>
          <li><a href="#about" className="hover:text-white transition">À propos</a></li>
          <li><a href="#services" className="hover:text-white transition">Services</a></li>
          <li><a href="#contact" className="hover:text-white transition">Contact</a></li>
        </ul>
      </div>

      {/* Comptes */}
      <div>
        <h4 className="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Compte</h4>
        <ul className="space-y-2 text-sm">
          <li><a href={route("login")} className="hover:text-white transition">Se connecter</a></li>
          <li><a href={route("register")} className="hover:text-white transition">S'inscrire</a></li>
        </ul>
      </div>

      {/* Réseaux sociaux */}
      <div>
        <h4 className="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Suivez-nous</h4>
        <div className="flex space-x-4">
           <a
          href="https://www.facebook.com/"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Facebook"
          className="text-[#1b2336] hover:text-blue-400 transition"
        >
          <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22 12.073C22 6.477 17.523 2 12 2S2 6.477 2 12.073c0 5.016 3.657 9.163 8.438 9.877v-6.987h-2.54v-2.89h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.343 21.236 22 17.089 22 12.073z"/>
          </svg>
        </a>
        <a
          href="https://www.linkedin.com/"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="LinkedIn"
          className="text-[#1b2336] hover:text-blue-400 transition"
        >
          <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.27c-.97 0-1.75-.79-1.75-1.76 0-.97.78-1.76 1.75-1.76s1.75.79 1.75 1.76c0 .97-.78 1.76-1.75 1.76zm13.5 10.27h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.76 1.37-1.56 2.82-1.56 3.01 0 3.57 1.98 3.57 4.56v4.77z"/>
          </svg>
        </a>
        <a
          href="https://twitter.com/"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Twitter"
          className="text-[#1b2336] hover:text-blue-400 transition"
        >
          <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 4.557a9.93 9.93 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724c-.951.564-2.005.974-3.127 1.195a4.92 4.92 0 0 0-8.388 4.482C7.691 8.095 4.066 6.13 1.64 3.161c-.542.929-.856 2.005-.856 3.163 0 2.18 1.11 4.102 2.797 5.229a4.904 4.904 0 0 1-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 0 1-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 0 1 0 21.543a13.94 13.94 0 0 0 7.548 2.209c9.057 0 14.009-7.496 14.009-13.986 0-.21 0-.423-.016-.634A9.936 9.936 0 0 0 24 4.557z"/>
          </svg>
        </a>
        <a
          href="https://www.instagram.com/"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Instagram"
          className="text-[#1b2336] hover:text-pink-400 transition"
        >
          <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.567 5.782 2.295 7.148 2.233 8.414 2.175 8.794 2.163 12 2.163zm0-2.163C8.736 0 8.332.012 7.052.07 5.771.128 4.615.388 3.678 1.325 2.74 2.263 2.48 3.419 2.422 4.7 2.364 5.98 2.352 6.384 2.352 12c0 5.616.012 6.02.07 7.3.058 1.281.318 2.437 1.256 3.375.937.937 2.093 1.197 3.374 1.255 1.28.058 1.684.07 7.3.07s6.02-.012 7.3-.07c1.281-.058 2.437-.318 3.375-1.255.937-.938 1.197-2.094 1.255-3.375.058-1.28.07-1.684.07-7.3 0-5.616-.012-6.02-.07-7.3-.058-1.281-.318-2.437-1.255-3.375C20.437.388 19.281.128 18 .07 16.72.012 16.316 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/>
          </svg>
        </a>
        </div>
      </div>
    </div>

    {/* Footer Bottom */}
    <div className="mt-6 text-center text-xs text-gray-100">
      &copy; {new Date().getFullYear()} Offitrade. Tous droits réservés. | Made with ❤️ by Offitrade Team
    </div>
  </div>
</footer>

    </>
  );
}