import { Link } from 'react-router-dom'

export default function NotFound() {
  return (
    <main>
      <section className="section" aria-labelledby="notfound-heading">
        <p className="section-label">Error</p>
        <h1
          id="notfound-heading"
          className="glitch section-title"
          data-text="404"
          style={{ fontSize: 'clamp(4rem, 12vw, 8rem)', marginBottom: '1rem' }}
        >
          404
        </h1>
        <p style={{ fontFamily: 'var(--font-mono)', color: 'var(--dim)', marginBottom: '2rem' }}>
          Route not found.
        </p>
        <Link to="/" className="btn btn-primary">← Back to home</Link>
      </section>
    </main>
  )
}
