import { useState } from 'react';
import { Menu, X, Phone, Calendar } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';

interface NavItem {
  label: string;
  href: string;
}

const navItems: NavItem[] = [
  { label: 'Accueil', href: '/' },
  { label: 'Services', href: '/services' },
  { label: 'À Propos', href: '/about' },
  { label: 'Contact', href: '/contact' },
];

export default function Navbar() {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <nav className='sticky top-0 z-50 w-full border-b border-[var(--color-secondary-gray)] bg-[var(--color-primary-background)]/95 backdrop-blur supports-[backdrop-filter]:bg-[var(--color-primary-background)]/80'>
      <div className='container mx-auto px-4 sm:px-6 lg:px-8'>
        <div className='flex h-20 items-center justify-between'>
          {/* Logo */}
          <a
            href='/'
            className='flex items-center space-x-2 transition-opacity hover:opacity-80'
          >
            <div className='text-2xl font-[var(--font-heading)] tracking-[var(--letter-spacing-wide)] text-[var(--color-text-heading)]'>
              CG Aesthetics
            </div>
          </a>

          {/* Desktop Navigation */}
          <div className='hidden md:flex md:items-center md:space-x-8'>
            {navItems.map((item) => (
              <a
                key={item.href}
                href={item.href}
                className='text-[var(--font-size-body)] font-[var(--font-body)] transition-colors hover:text-[var(--color-secondary-mauve)]'
              >
                {item.label}
              </a>
            ))}
          </div>

          {/* Desktop CTA Buttons */}
          <div className='hidden md:flex md:items-center md:space-x-4'>
            <Button
              variant='ghost'
              size='default'
              className='gap-2'
              onClick={() => (window.location.href = 'tel:+41763999732')}
            >
              <Phone className='h-4 w-4' />
              <span className='hidden lg:inline'>Appeler</span>
            </Button>
            <Button
              size='default'
              className='gap-2 bg-[var(--color-accent-rose-gold)] hover:bg-[var(--color-accent-rose-gold-dark)]'
              onClick={() => (window.location.href = '/reserver')}
            >
              <Calendar className='h-4 w-4' />
              Réserver
            </Button>
          </div>

          {/* Mobile Menu Button */}
          <div className='md:hidden'>
            <Sheet open={isOpen} onOpenChange={setIsOpen}>
              <SheetTrigger asChild>
                <Button variant='ghost' size='icon' aria-label='Menu'>
                  {isOpen ? (
                    <X className='h-6 w-6' />
                  ) : (
                    <Menu className='h-6 w-6' />
                  )}
                </Button>
              </SheetTrigger>
              <SheetContent
                side='right'
                className='w-[300px] bg-[var(--color-primary-background)] p-6'
              >
                <div className='flex flex-col space-y-6 mt-8'>
                  {navItems.map((item) => (
                    <a
                      key={item.href}
                      href={item.href}
                      className='text-lg font-[var(--font-body)] text-[var(--color-text-body)] transition-colors hover:text-[var(--color-secondary-mauve)]'
                      onClick={() => setIsOpen(false)}
                    >
                      {item.label}
                    </a>
                  ))}
                  <div className='pt-4 space-y-3 border-t border-[var(--color-secondary-gray)]'>
                    <Button
                      variant='outline'
                      className='w-full gap-2'
                      onClick={() => {
                        setIsOpen(false);
                        window.location.href = 'tel:+41763999732';
                      }}
                    >
                      <Phone className='h-4 w-4' />
                      Appeler
                    </Button>
                    <Button
                      className='w-full gap-2 bg-[var(--color-accent-rose-gold)] hover:bg-[var(--color-accent-rose-gold-dark)]'
                      onClick={() => {
                        setIsOpen(false);
                        window.location.href = '/reserver';
                      }}
                    >
                      <Calendar className='h-4 w-4' />
                      Réserver
                    </Button>
                  </div>
                </div>
              </SheetContent>
            </Sheet>
          </div>
        </div>
      </div>
    </nav>
  );
}
