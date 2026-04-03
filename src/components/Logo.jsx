import { useState } from 'react'

export default function Logo() {
  const [hovered, setHovered] = useState(false)

  return (
    <a
      href="#/"
      aria-label="DangeloVF — home"
      style={{ textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: '0.15rem' }}
      onMouseEnter={() => setHovered(true)}
      onMouseLeave={() => setHovered(false)}
    >
      <span style={{
        fontFamily:  'var(--font-display)',
        fontSize:    '1.6rem',
        color:       hovered ? 'var(--white)' : 'var(--cyan)',
        letterSpacing: '0.05em',
        transition:  'color 0.2s, text-shadow 0.2s',
        textShadow:  hovered ? '0 0 18px rgba(255,133,194,0.55)' : 'none',
        lineHeight:  1,
      }}>
        DangeloVF
      </span>
      <span
        aria-hidden="true"
        style={{
          color:      'var(--light-magenta)',
          fontSize:   '0.9rem',
          opacity:    hovered ? 1 : 0,
          transition: 'opacity 0.2s',
          marginLeft: '0.1rem',
          lineHeight: 1,
        }}
      >
        ♥
      </span>
    </a>
  )
}
