import { useState, useEffect } from 'react'
import { api } from '../lib/api'

const separator = <span style={{ color: 'var(--light-magenta)', fontSize: '0.8rem', margin: '0 1rem' }} aria-hidden="true">◆</span>

export default function Ticker() {
  const [items, setItems]   = useState([])
  const [error, setError]   = useState(false)

  useEffect(() => {
    api.getSkills()
      .then(skills => setItems(skills.map(s => s.name)))
      .catch(() => setError(true))
  }, [])

  if (error) {
    const errorContent = Array.from({ length: 32 }, (_, i) => [
      <span key={`e-${i}`} style={{ fontFamily: 'var(--font-mono)', fontSize: '0.8rem', color: 'var(--light-magenta)', letterSpacing: '0.1em' }}>ERROR</span>,
      <span key={`s-${i}`}>{separator}</span>,
    ]).flat()

    return (
      <div
        aria-label="Skills ticker — error"
        style={{ background: 'var(--bg2)', borderTop: '1px solid rgba(0,245,255,0.12)', borderBottom: '1px solid rgba(0,245,255,0.12)', padding: '0.75rem 0', overflow: 'hidden' }}
      >
        <div className="ticker-track" aria-hidden="true">
          {errorContent}
          {errorContent}
        </div>
      </div>
    )
  }

  const content = items.flatMap((item, i) => [
    <span key={`a-${i}`} style={{ fontFamily: 'var(--font-mono)', fontSize: '0.8rem', color: 'var(--dim)', letterSpacing: '0.1em', textTransform: 'uppercase' }}>{item}</span>,
    <span key={`s-${i}`}>{separator}</span>,
  ])

  return (
    <div
      aria-label="Skills ticker"
      style={{ background: 'var(--bg2)', borderTop: '1px solid rgba(0,245,255,0.12)', borderBottom: '1px solid rgba(0,245,255,0.12)', padding: '0.75rem 0', overflow: 'hidden' }}
    >
      <div className="ticker-track" aria-hidden="true">
        {content}
        {content}
      </div>
    </div>
  )
}
