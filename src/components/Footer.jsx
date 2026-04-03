export default function Footer() {
  return (
    <footer
      style={{ background: 'var(--bg)', borderTop: '1px solid rgba(0,245,255,0.08)', padding: '2rem 1.5rem' }}
    >
      <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--dim)', margin: '0 auto', maxWidth: 1100, letterSpacing: '0.05em', display: 'flex', alignItems: 'center', justifyContent: 'flex-end', gap: '0.5rem' }}>
        <span style={{ color: 'var(--cyan)' }}>DangeloVF</span>
        <span>·</span>
        <span>Built with React + Vite + <span style={{color: 'var(--light-magenta)'}}>&hearts;</span></span>
        <span>·</span>
        <span >©{new Date().getFullYear()}</span>
      </p>
    </footer>
  )
}
