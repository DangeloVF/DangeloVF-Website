import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import { api } from '../lib/api'
import ProjectCard from './ProjectCard'

export default function Projects({ preview = false }) {
  const [projects, setProjects] = useState([])
  const [loading, setLoading]   = useState(true)
  const [error, setError]       = useState(null)

  useEffect(() => {
    api.getProjects()
      .then(setProjects)
      .catch(() => setError('Could not load projects.'))
      .finally(() => setLoading(false))
  }, [])

  const featured = projects.filter(p => p.featured)
  const rest      = projects.filter(p => !p.featured)

  const visibleFeatured = preview ? featured : featured
  const visibleRest     = preview ? [] : rest

  return (
    <section id="projects" className="section" aria-labelledby="projects-heading">
      <p className="section-label">02. Work</p>
      <h2 id="projects-heading" className="section-title">
        <span className="section-number">{'>'}</span> Projects
      </h2>

      {loading && <p className="loading-text">Loading...</p>}
      {error   && <p role="alert">{error}</p>}

      {visibleFeatured.map(p => <ProjectCard key={p.id} project={p} featured />)}

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))', gap: '1.5rem' }}>
        {visibleRest.map(p => <ProjectCard key={p.id} project={p} />)}
      </div>

      {preview && !loading && !error && (
        <div style={{ marginTop: '2rem' }}>
          <Link to="/projects" className="btn btn-secondary">View All Projects</Link>
        </div>
      )}
      <span aria-hidden="true" className="section-watermark">.02</span>
    </section>
  )
}
