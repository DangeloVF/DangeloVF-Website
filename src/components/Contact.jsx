export default function Contact() {
  const labelStyle = {
    fontFamily: 'var(--font-mono)',
    fontSize: '0.7rem',
    color: 'var(--cyan)',
    letterSpacing: '0.15em',
    minWidth: 90,
    flexShrink: 0,
  }

  const platformLink = (label, href) => (
    <a
      key={label}
      href={href}
      target="_blank"
      rel="noopener noreferrer"
      style={{ fontFamily: 'var(--font-mono)', fontSize: '0.8rem', color: 'var(--dim)', textDecoration: 'none' }}
      onMouseEnter={e => (e.currentTarget.style.color = 'var(--light-magenta)')}
      onMouseLeave={e => (e.currentTarget.style.color = 'var(--dim)')}
    >
      {label}
    </a>
  )

  return (
    <section id="contact" aria-labelledby="contact-heading" style={{ position: 'relative', isolation: 'isolate', borderTop: '2px solid transparent', borderBottom: '2px solid transparent', borderImage: 'linear-gradient(90deg, transparent 0%, transparent 2%, rgba(0,245,255,0.06) 2%, rgba(0,245,255,0.06) 3%, transparent 3%, transparent 5%, rgba(0,245,255,0.12) 5%, rgba(0,245,255,0.12) 6%, rgba(0,245,255,0.22) 6%, rgba(0,245,255,0.22) 8%, rgba(0,245,255,0.35) 8%, rgba(0,245,255,0.35) 12%, rgba(0,245,255,0.4) 12%, rgba(0,245,255,0.4) 88%, rgba(0,245,255,0.35) 88%, rgba(0,245,255,0.35) 92%, rgba(0,245,255,0.22) 92%, rgba(0,245,255,0.22) 94%, rgba(0,245,255,0.12) 94%, rgba(0,245,255,0.12) 95%, transparent 95%, transparent 97%, rgba(0,245,255,0.06) 97%, rgba(0,245,255,0.06) 98%, transparent 98%) 1' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto', padding: '5rem 1.5rem' }}>
        <p className="section-label">06. Say Hello</p>
        <div className="contact-grid">
          <div>
            <h2 id="contact-heading" className="section-title">
              <span className="section-number">{'>'}</span> Contact
            </h2>

            <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
              <li style={{ display: 'flex', alignItems: 'baseline', gap: '1rem' }}>
                <span style={labelStyle}>EMAIL</span>
                <a
                  href="mailto:info@dangelovf.com"
                  style={{ fontFamily: 'var(--font-mono)', fontSize: '0.9rem', color: 'var(--white)', textDecoration: 'none' }}
                  onMouseEnter={e => (e.currentTarget.style.color = 'var(--light-magenta)')}
                  onMouseLeave={e => (e.currentTarget.style.color = 'var(--white)')}
                >
                  info@dangelovf.com
                </a>
              </li>

              <li style={{ display: 'flex', alignItems: 'flex-start', gap: '1rem' }}>
                <span style={labelStyle}>SOCIALS</span>
                <div>
                  <span style={{ fontFamily: 'var(--font-mono)', fontSize: '0.9rem', color: 'var(--white)', display: 'block', marginBottom: '0.6rem' }}>
                    @DangeloVF
                  </span>
                  <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.4rem 0' }}>
                    {platformLink('Instagram', 'https://www.instagram.com/DangeloVF')}
                    <span style={{ color: 'var(--dim)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem', margin: '0 0.5rem' }}>·</span>
                    {platformLink('Facebook', 'https://www.facebook.com/DangeloVF')}
                    <span style={{ color: 'var(--dim)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem', margin: '0 0.5rem' }}>·</span>
                    {platformLink('Twitter / X', 'https://x.com/DangeloVF1')}
                    <span style={{ color: 'var(--dim)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem', margin: '0 0.5rem' }}>·</span>
                    {platformLink('LinkedIn', 'https://www.linkedin.com/in/dangelovf')}
                    <span style={{ color: 'var(--dim)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem', margin: '0 0.5rem' }}>·</span>
                    {platformLink('GitHub', 'https://github.com/DangeloVF')}
                  </div>
                </div>
              </li>
            </ul>
          </div>

        <div
          className="card"
          style={{ minWidth: 220, fontFamily: 'var(--font-mono)', fontSize: '0.8rem', lineHeight: 2, color: 'var(--dim)' }}
        >
          <div style={{ color: 'var(--cyan)', marginBottom: '0.75rem' }}>$ status --verbose</div>
          <p>
            <span style={{ color: 'var(--white)' }}>Currently available</span> for full-time<br />
            roles and freelance projects in<br />
            embedded systems, DSP, and<br />
            audio-visual technology.
          </p>
          <p style={{ marginTop: '1rem' }}>
            Response time:{' '}
            <span style={{ color: 'var(--cyan)' }}>within 48 hours.</span>
          </p>
        </div>
        </div>
        <span aria-hidden="true" className="section-watermark">.06</span>
      </div>
    </section>
  )
}
