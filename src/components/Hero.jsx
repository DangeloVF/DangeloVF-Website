import { useState, useEffect } from 'react'


const SUBTITLE = 'Computer Engineer & Cyber Artist'

export default function Hero() {
  const [typed, setTyped] = useState('')

  useEffect(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      setTyped(SUBTITLE)
      return
    }
    let i = 0
    const start = setTimeout(() => {
      const tick = setInterval(() => {
        i++
        setTyped(SUBTITLE.slice(0, i))
        if (i >= SUBTITLE.length) clearInterval(tick)
      }, 50)
      return () => clearInterval(tick)
    }, 600)
    return () => clearTimeout(start)
  }, [])

  return (
    <section
      style={{ flex: 1, display: 'flex', alignItems: 'center', position: 'relative', isolation: 'isolate', overflow: 'hidden' }}
      aria-label="Introduction"
    >
      <div style={{ maxWidth: 1100, margin: '0 auto', padding: '6rem 1.5rem 4rem', width: '100%' }}>
        <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.8rem', color: 'var(--cyan)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '1rem' }}>
          &gt; Hello, world. I'm
        </p>

        <h1
          className="glitch"
          data-text="D'Angelo V. F."
          style={{ fontFamily: 'var(--font-display)', fontSize: 'clamp(3rem, 10vw, 7rem)', color: 'var(--white)', margin: '0 0 0.5rem', lineHeight: 1 }}
        >
          D'Angelo V. F.
        </h1>

        <h2
          className="cursor"
          style={{ fontFamily: 'var(--font-display)', fontSize: 'clamp(1.4rem, 4vw, 2.5rem)', color: 'var(--light-magenta)', margin: '0 0 1.5rem', fontWeight: 400, minHeight: '1.2em' }}
        >
          {typed}
        </h2>

        <p style={{ fontFamily: 'var(--font-body)', fontSize: '1.1rem', color: 'var(--dim)', maxWidth: 480, lineHeight: 1.7, marginBottom: '2.5rem' }}>
          Signal processing, embedded systems, and audio-visual tech.
          Master's graduate from Bristol — building things that you can see and hear.
        </p>

        <div style={{ display: 'flex', gap: '1rem', flexWrap: 'wrap' }}>
          <a href="#/projects" className="btn btn-primary">View Projects</a>
          <a href="#/contact"  className="btn btn-secondary">Get In Touch</a>
        </div>

        {/* Decorative terminal line */}
        <div
          aria-hidden="true"
          style={{ marginTop: '4rem', fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--dim)', letterSpacing: '0.05em' }}
        >
          <span style={{ color: 'var(--cyan)' }}>~/dangelovf</span> $ npm run portfolio
        </div>
      </div>

      {/* Pixel sprite — hidden on mobile via .hero-sprite */}
      {/* <img
        src={spriteUrl}
        alt=""
        aria-hidden="true"
        className="hero-sprite"
        style={{
          position:        'absolute',
          right:           'calc((100vw - min(100vw, 1100px)) / 2 + 6rem)',
          bottom:          '6rem',
          width:           138,
          height:          'auto',
          imageRendering:  'pixelated',
          opacity:         0.85,
        }}
      /> */}

      <span aria-hidden="true" className="section-watermark">.main</span>
    </section>
  )
}
