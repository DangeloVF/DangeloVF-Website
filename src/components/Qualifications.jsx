import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import { api } from '../lib/api'

export default function Qualifications({ preview = false }) {
  const [qualifications, setQualifications] = useState([])
  const [loading, setLoading]               = useState(true)
  const [error, setError]                   = useState(null)

  useEffect(() => {
    api.getQualifications()
      .then(setQualifications)
      .catch(() => setError('Could not load qualifications.'))
      .finally(() => setLoading(false))
  }, [])

  const visible = preview ? qualifications.slice(0, 4) : qualifications

  return (
    <section id="qualifications" className="section" aria-labelledby="qualifications-heading">
      <p className="section-label">04. Education</p>
      <h2 id="qualifications-heading" className="section-title">
        <span className="section-number">{'>'}</span> Qualifications
      </h2>

      {loading && <p className="loading-text">Loading...</p>}
      {error   && <p role="alert">{error}</p>}

      <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
        {visible.map(q => (
          <li key={q.id} className="card" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline', gap: '1rem', flexWrap: 'wrap' }}>
            <div className="card-reveal" aria-hidden="true" />
            <div>
              <p style={{ fontFamily: 'var(--font-display)', fontSize: '1.6rem', color: 'var(--white)', lineHeight: 1.2 }}>{q.qualification}</p>
              <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.8rem', color: 'var(--cyan)', marginTop: '0.3rem' }}>{q.institution}</p>
            </div>
            <div style={{ textAlign: 'right', flexShrink: 0 }}>
              <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.85rem', color: 'var(--white)' }}>{q.grade}</p>
              <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--dim)', marginTop: '0.2rem' }}>{q.year}</p>
            </div>
          </li>
        ))}
      </ul>

      {preview && !loading && !error && qualifications.length > 4 && (
        <div style={{ marginTop: '2rem' }}>
          <Link to="/qualifications" className="btn btn-secondary">View All Qualifications</Link>
        </div>
      )}
      <span aria-hidden="true" className="section-watermark">.04</span>
    </section>
  )
}
