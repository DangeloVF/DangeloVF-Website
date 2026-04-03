import { useState, useEffect, useRef } from 'react'
import { api } from '../lib/api'

const CATEGORY_ORDER = ['Languages', 'Frontend', 'Backend', 'Tools']

export default function Skills() {
  const [skills, setSkills]   = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)
  const [inView, setInView]   = useState(false)
  const [barsReady, setBarsReady] = useState(false)
  const sectionRef            = useRef(null)

  useEffect(() => {
    api.getSkills()
      .then(setSkills)
      .catch(() => setError('Could not load skills.'))
      .finally(() => setLoading(false))
  }, [])

  useEffect(() => {
    const el = sectionRef.current
    if (!el) return
    const io = new IntersectionObserver(
      ([entry]) => { if (entry.isIntersecting) { setInView(true); io.disconnect() } },
      { threshold: 0.1 }
    )
    io.observe(el)
    return () => io.disconnect()
  }, [])

  // Only start bars after both data and visibility are ready, and after
  // at least one paint at width:0% so the CSS transition has something to animate from.
  useEffect(() => {
    if (!inView || skills.length === 0) return
    const id = requestAnimationFrame(() => requestAnimationFrame(() => setBarsReady(true)))
    return () => cancelAnimationFrame(id)
  }, [inView, skills])

  // Build ordered category list: known categories first, then any extras from the DB
  const allCategories = [
    ...CATEGORY_ORDER,
    ...skills
      .map(s => s.category)
      .filter(cat => cat && !CATEGORY_ORDER.includes(cat))
      .filter((cat, i, arr) => arr.indexOf(cat) === i),
  ]

  const grouped = allCategories.reduce((acc, cat) => {
    acc[cat] = skills.filter(s => s.category === cat)
    return acc
  }, {})

  return (
    <section ref={sectionRef} id="skills" aria-labelledby="skills-heading" style={{ position: 'relative', isolation: 'isolate', borderTop: '2px solid transparent', borderImage: 'linear-gradient(90deg, transparent 0%, transparent 2%, rgba(0,245,255,0.06) 2%, rgba(0,245,255,0.06) 3%, transparent 3%, transparent 5%, rgba(0,245,255,0.12) 5%, rgba(0,245,255,0.12) 6%, rgba(0,245,255,0.22) 6%, rgba(0,245,255,0.22) 8%, rgba(0,245,255,0.35) 8%, rgba(0,245,255,0.35) 12%, rgba(0,245,255,0.4) 12%, rgba(0,245,255,0.4) 88%, rgba(0,245,255,0.35) 88%, rgba(0,245,255,0.35) 92%, rgba(0,245,255,0.22) 92%, rgba(0,245,255,0.22) 94%, rgba(0,245,255,0.12) 94%, rgba(0,245,255,0.12) 95%, transparent 95%, transparent 97%, rgba(0,245,255,0.06) 97%, rgba(0,245,255,0.06) 98%, transparent 98%) 1' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto', padding: '5rem 1.5rem', position: 'relative' }}>
        <p className="section-label">03. Capabilities</p>
        <h2 id="skills-heading" className="section-title">
          <span className="section-number">{'>'}</span> Skills
        </h2>

        {loading && <p className="loading-text">Loading...</p>}
        {error   && <p role="alert">{error}</p>}

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(240px, 1fr))', gap: '2.5rem' }}>
          {allCategories.map(cat => {
            const items = grouped[cat]
            if (!items?.length) return null
            return (
              <div key={cat}>
                <h3 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--cyan)', letterSpacing: '0.15em', textTransform: 'uppercase', marginBottom: '1.25rem' }}>
                  {cat}
                </h3>
                <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: '0.9rem' }}>
                  {items.map(skill => (
                    <li key={skill.id}>
                      <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '0.3rem' }}>
                        <span style={{ fontFamily: 'var(--font-body)', fontSize: '0.95rem', color: 'var(--white)' }}>{skill.name}</span>
                        <span style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--dim)' }}>{skill.proficiency}%</span>
                      </div>
                      <div
                        role="progressbar"
                        aria-valuenow={skill.proficiency}
                        aria-valuemin={0}
                        aria-valuemax={100}
                        aria-label={`${skill.name} proficiency`}
                        style={{ background: 'rgba(0,245,255,0.1)', height: 4, borderRadius: 2 }}
                      >
                        <div style={{ height: '100%', width: `${barsReady ? skill.proficiency : 0}%`, background: 'var(--cyan)', borderRadius: 2, transition: 'width 1s ease' }} />
                      </div>
                    </li>
                  ))}
                </ul>
              </div>
            )
          })}
        </div>
        <span aria-hidden="true" className="section-watermark">.03</span>
      </div>
    </section>
  )
}
