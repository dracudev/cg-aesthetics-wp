import { MapPin, Phone, Mail, Instagram, Facebook, Clock } from 'lucide-react';
import { Separator } from '@/components/ui/separator';

const footerLinks = {
  services: [
    { label: 'Soins du visage', href: '/services/soins-visage' },
    { label: 'Massages', href: '/services/massages' },
    { label: 'Épilation', href: '/services/epilation' },
    { label: 'Manucure & Pédicure', href: '/services/manucure-pedicure' },
  ],
  info: [
    { label: 'À Propos', href: '/about' },
    { label: 'Contact', href: '/contact' },
    { label: 'Blog', href: '/blog' },
    { label: 'Témoignages', href: '/testimonials' },
  ],
  legal: [
    { label: 'Mentions Légales', href: '/mentions-legales' },
    { label: 'Politique de Confidentialité', href: '/privacy' },
    { label: 'CGV', href: '/cgv' },
  ],
};

const socialLinks = [
  { icon: Instagram, href: 'https://instagram.com', label: 'Instagram' },
  { icon: Facebook, href: 'https://facebook.com', label: 'Facebook' },
];

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className='bg-[var(--color-white)] border-t border-[var(--color-secondary-gray)]'>
      {/* Main Footer Content */}
      <div className='container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16'>
        <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12'>
          {/* Brand & Contact Info */}
          <div className='space-y-4'>
            <h3 className='font-[var(--font-heading)] text-2xl tracking-[var(--letter-spacing-wide)] text-[var(--color-text-heading)]'>
              CG Aesthetics
            </h3>
            <p className='text-[var(--font-size-body-sm)] leading-[var(--line-height-relaxed)]'>
              Votre sanctuaire de beauté et de bien-être à Montreux, au bord du
              Lac Léman. Nous offrons des soins de qualité dans une atmosphère
              sereine et luxueuse.
            </p>

            <div className='space-y-3 pt-2'>
              <div className='flex items-start gap-3 text-[var(--font-size-body-sm)]'>
                <MapPin className='h-5 w-5 text-[var(--color-accent-rose-gold)] mt-0.5 flex-shrink-0' />
                <span>
                  Avenue des Alpes, 60
                  <br />
                  Montreux, Suisse
                </span>
              </div>
              <div className='flex items-center gap-3 text-[var(--font-size-body-sm)]'>
                <Phone className='h-5 w-5 text-[var(--color-accent-rose-gold)] flex-shrink-0' />
                <a
                  href='tel:+41763999732'
                  className='hover:text-[var(--color-secondary-mauve)] transition-colors'
                >
                  +41 76 399 97 32
                </a>
              </div>
              <div className='flex items-center gap-3 text-[var(--font-size-body-sm)]'>
                <Mail className='h-5 w-5 text-[var(--color-accent-rose-gold)] flex-shrink-0' />
                <a
                  href='mailto:contact@cgaesthetics.ch'
                  className='hover:text-[var(--color-secondary-mauve)] transition-colors'
                >
                  contact@cgaesthetics.ch
                </a>
              </div>
              <div className='flex items-start gap-3 text-[var(--font-size-body-sm)]'>
                <Clock className='h-5 w-5 text-[var(--color-accent-rose-gold)] mt-0.5 flex-shrink-0' />
                <div>
                  <p>Lundi - Vendredi: 9h00 - 18h00</p>
                  <p>Samedi: Fermé</p>
                  <p>Dimanche: Fermé</p>
                </div>
              </div>
            </div>
          </div>

          {/* Services Links */}
          <div className='space-y-4'>
            <h4 className='font-[var(--font-body)] text-[var(--font-size-h6)]'>
              Nos Services
            </h4>
            <ul className='space-y-2'>
              {footerLinks.services.map((link) => (
                <li key={link.href}>
                  <a
                    href={link.href}
                    className='text-[var(--font-size-body-sm)] hover:text-[var(--color-secondary-mauve)] transition-colors'
                  >
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Information Links */}
          <div className='space-y-4'>
            <h4 className='font-[var(--font-body)] text-[var(--font-size-h6)]'>
              Informations
            </h4>
            <ul className='space-y-2'>
              {footerLinks.info.map((link) => (
                <li key={link.href}>
                  <a
                    href={link.href}
                    className='text-[var(--font-size-body-sm)] hover:text-[var(--color-secondary-mauve)] transition-colors'
                  >
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Newsletter & Social */}
          <div className='space-y-4'>
            <h4 className='font-[var(--font-body)] text-[var(--font-size-h6)]'>
              Restez Connecté
            </h4>
            <p className='text-[var(--font-size-body-sm)]'>
              Suivez-nous sur les réseaux sociaux pour nos dernières actualités
              et offres exclusives.
            </p>
            <div className='flex gap-3 pt-2'>
              {socialLinks.map((social) => {
                const Icon = social.icon;
                return (
                  <a
                    key={social.label}
                    href={social.href}
                    target='_blank'
                    rel='noopener noreferrer'
                    aria-label={social.label}
                    className='flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-secondary-gray)] bg-[var(--color-white)] text-[var(--color-text-body)] transition-all hover:border-[var(--color-accent-rose-gold)] hover:bg-[var(--color-primary-accent-light)] hover:text-[var(--color-secondary-mauve)]'
                  >
                    <Icon className='h-5 w-5' />
                  </a>
                );
              })}
            </div>
          </div>
        </div>
      </div>

      <Separator className='bg-[var(--color-secondary-gray)]' />

      {/* Bottom Bar */}
      <div className='container mx-auto px-4 sm:px-6 lg:px-8 py-6'>
        <div className='flex flex-col md:flex-row justify-between items-center gap-4'>
          <p className='text-[var(--font-size-small)] text-center md:text-left'>
            © {currentYear} CG Aesthetics. Tous droits réservés.
          </p>
          <div className='flex flex-wrap justify-center gap-4 md:gap-6'>
            {footerLinks.legal.map((link, index) => (
              <span
                key={link.href}
                className='flex items-center gap-4 md:gap-6'
              >
                <a
                  href={link.href}
                  className='text-[var(--font-size-small)] hover:text-[var(--color-secondary-mauve)] transition-colors'
                >
                  {link.label}
                </a>
                {index < footerLinks.legal.length - 1 && (
                  <span className='text-[var(--color-text-light)]'>•</span>
                )}
              </span>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}
