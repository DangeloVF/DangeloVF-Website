import { useState, useEffect } from 'react'
import { useLocation } from 'react-router-dom'
import { api } from '../lib/api'
import Logo from './Logo'

const links = [
  { label: 'About',          href: '#/about' },
  { label: 'Projects',       href: '#/projects' },
  { label: 'Skills',         href: '#/skills' },
  { label: 'Qualifications', href: '#/qualifications' },
  { label: 'Blog',           href: '#/blog' },
  { label: 'Contact',        href: '#/contact' },
]

function NavItem({ label, href, isActive }) {
  const [hovered, setHovered] = useState(false)
  const lit = isActive || hovered
  return (
    <a
      href={href}
      style={{
        fontFamily:     'var(--font-mono)',
        fontSize:       '0.8rem',
        color:          lit ? 'var(--white)' : 'var(--dim)',
        letterSpacing:  '0.1em',
        textDecoration: 'none',
        textTransform:  'uppercase',
        transition:     'color 0.2s, text-shadow 0.2s',
        textShadow:     lit ? '0 0 14px rgba(255,133,194,0.65)' : 'none',
      }}
      onMouseEnter={() => setHovered(true)}
      onMouseLeave={() => setHovered(false)}
    >
      {label}
    </a>
  )
}

export default function Nav() {
  const [status, setStatus] = useState(null)
  const [error, setError]   = useState(false)
  const [open, setOpen]     = useState(false)
  const location            = useLocation()

  useEffect(() => {
    api.getBio()
      .then(d => setStatus(d.available))
      .catch(() => setError(true))
  }, [])

  const statusConfig = {
    ready:   { color: '#00ff88', label: 'AVAILABLE' },
    busy:    { color: '#ffe500', label: 'BUSY'      },
    offline: { color: '#ff4444', label: 'OFFLINE'   },
  }

  return (
    <header
      className="fixed top-0 left-0 right-0 z-50"
      style={{ background: 'rgba(8,8,16,0.85)', backdropFilter: 'blur(8px)', borderBottom: '1px solid rgba(0,245,255,0.12)' }}
    >
      <nav
        className="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between"
        aria-label="Main navigation"
      >
        <Logo />

        {/* Desktop links */}
        <ul className="hidden md:flex items-center gap-8 list-none m-0 p-0">
          {links.map(({ label, href }) => (
            <li key={label}>
              <NavItem
                label={label}
                href={href}
                isActive={'#' + location.pathname === href}
              />
            </li>
          ))}
        </ul>

        {/* Available status + hamburger */}
        <div className="flex items-center gap-4">
          {error
            ? (
              <span
                className="hidden md:flex items-center gap-2"
                style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--dim)', letterSpacing: '0.1em' }}
                aria-label="Status unavailable"
              >
                <span style={{ width: 8, height: 8, borderRadius: '50%', background: 'var(--dim)', display: 'inline-block' }} aria-hidden="true" />
                STATUS N/A
              </span>
            )
            : status && statusConfig[status] && (() => {
              const { color, label } = statusConfig[status]
              return (
                <span
                  className="hidden md:flex items-center gap-2"
                  style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color, letterSpacing: '0.1em' }}
                  aria-label={label}
                >
                  <span style={{ width: 8, height: 8, borderRadius: '50%', background: color, display: 'inline-block', boxShadow: `0 0 6px ${color}` }} aria-hidden="true" />
                  {label}
                </span>
              )
            })()
          }

          {/* Mobile hamburger */}
          <button
            className="md:hidden"
            style={{ background: 'none', border: 'none', color: 'var(--cyan)', cursor: 'pointer', fontSize: '1.4rem', padding: 4 }}
            aria-label={open ? 'Close menu' : 'Open menu'}
            aria-expanded={open}
            onClick={() => setOpen(o => !o)}
          >
            {open ? '✕' : '☰'}
          </button>
        </div>
      </nav>

      {/* Mobile drawer */}
      {open && (
        <ul
          className="md:hidden list-none m-0 px-6 pb-6"
          style={{ background: 'var(--bg2)', borderTop: '1px solid rgba(0,245,255,0.1)' }}
        >
          {links.map(({ label, href }) => (
            <li key={label} style={{ borderBottom: '1px solid rgba(0,245,255,0.06)', padding: '0.75rem 0' }}>
              <a
                href={href}
                onClick={() => setOpen(false)}
                style={{ fontFamily: 'var(--font-mono)', fontSize: '0.9rem', color: 'var(--white)', textDecoration: 'none', letterSpacing: '0.1em', textTransform: 'uppercase' }}
              >
                {label}
              </a>
            </li>
          ))}
        </ul>
      )}
    </header>
  )
}
