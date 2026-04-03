import { useState, useEffect } from 'react'
import ReactMarkdown from 'react-markdown'
import { api } from '../lib/api'

export default function About() {
  const [bio, setBio]       = useState(null)
  const [loading, setLoading] = useState(true)
  const [error, setError]   = useState(null)

  useEffect(() => {
    api.getBio()
      .then(setBio)
      .catch(() => setError('Could not load bio.'))
      .finally(() => setLoading(false))
  }, [])

  return (
    <section id="about" className="section" aria-labelledby="about-heading" style={{ position: 'relative' }}>
      <p className="section-label">01. Background</p>
      <h2 id="about-heading" className="section-title">
        <span className="section-number">{'>'}</span> About
      </h2>

      <div style={{ display: 'grid', gridTemplateColumns: '1fr auto', gap: '4rem', alignItems: 'start' }}>
        <div>
          {loading && <p className="loading-text">Loading...</p>}
          {error   && <p role="alert">{error}</p>}
          {!loading && !error && bio?.about && (
            <ReactMarkdown components={{ img: () => null }}>{bio.about}</ReactMarkdown>
          )}
          {bio?.cv_file && (
            <a href={bio.cv_file} className="btn btn-primary" download aria-label="Download CV">
              Download CV
            </a>
          )}
        </div>

        {/* Terminal stat block */}
        <div
          aria-hidden="true"
          className="card"
          style={{ minWidth: 220, fontFamily: 'var(--font-mono)', fontSize: '0.8rem', lineHeight: 2, color: 'var(--dim)' }}
        >
          <div style={{ color: 'var(--cyan)', marginBottom: '0.5rem' }}>$ whoami</div>
          <table style={{ borderCollapse: 'collapse' }}>
            <tbody>
              <tr>
                <td style={{ color: 'var(--light-magenta)', paddingRight: '1rem', whiteSpace: 'nowrap', verticalAlign: 'top' }}>name:</td>
                <td>{bio?.name ?? "D'Angelo V. F."}</td>
              </tr>
              <tr>
                <td style={{ color: 'var(--light-magenta)', paddingRight: '1rem', whiteSpace: 'nowrap', verticalAlign: 'top' }}>pronouns:</td>
                <td>they/them</td>
              </tr>
              <tr>
                <td style={{ color: 'var(--light-magenta)', paddingRight: '1rem', whiteSpace: 'nowrap', verticalAlign: 'top' }}>role:</td>
                <td>{bio?.headline ?? 'CS & Electronics Grad'}</td>
              </tr>
              <tr>
                <td style={{ color: 'var(--light-magenta)', paddingRight: '1rem', whiteSpace: 'nowrap', verticalAlign: 'top' }}>base:</td>
                <td>Oxford, UK</td>
              </tr>
              <tr>
                <td style={{ color: 'var(--light-magenta)', paddingRight: '1rem', whiteSpace: 'nowrap', verticalAlign: 'top' }}>status:</td>
                <td>{(() => {
                  const cfg = { ready: ['#00ff88', 'Available'], busy: ['#ffe500', 'Busy'], offline: ['#ff4444', 'Offline'] }
                  const [color, label] = cfg[bio?.available] ?? ['var(--dim)', '—']
                  return <span style={{ color }}>{label}</span>
                })()}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <span aria-hidden="true" className="section-watermark">.01</span>
    </section>
  )
}
