import { useState, useEffect } from 'react'
import { useParams, Link } from 'react-router-dom'
import ReactMarkdown from 'react-markdown'
import { api } from '../lib/api'

const TAG_COLOURS = ['tag-cyan', 'tag-magenta', 'tag-yellow']

export default function ProjectPage() {
  const { slug }                  = useParams()
  const [project, setProject]     = useState(null)
  const [loading, setLoading]     = useState(true)
  const [notFound, setNotFound]   = useState(false)

  useEffect(() => {
    api.getProject(slug)
      .then(data => {
        if (!data) setNotFound(true)
        else setProject(data)
      })
      .catch(() => setNotFound(true))
      .finally(() => setLoading(false))
  }, [slug])

  if (loading) {
    return (
      <main>
        <section className="section">
          <p className="loading-text">Loading...</p>
        </section>
      </main>
    )
  }

  if (notFound) {
    return (
      <main>
        <section className="section">
          <p role="alert">Project not found.</p>
          <Link to="/projects" className="back-link">← Back to projects</Link>
        </section>
      </main>
    )
  }

  const tags = typeof project.tags === 'string' ? JSON.parse(project.tags) : (project.tags ?? [])

  return (
    <main>
      <article className="section" aria-labelledby="project-heading">
        <Link to="/projects" className="back-link">← Back to projects</Link>

        {project.thumbnail && <img src={project.thumbnail} alt="" className="post-thumb" />}

        <p className="post-meta">{project.year}</p>

        <h1 id="project-heading" className="post-title">{project.title}</h1>

        {tags.length > 0 && (
          <div className="tags">
            {tags.map((tag, i) => (
              <span key={tag} className={`tag ${TAG_COLOURS[i % 3]}`}>{tag}</span>
            ))}
          </div>
        )}

        <div style={{ display: 'flex', gap: '1rem', marginBottom: '2.5rem' }}>
          {project.github_url && <a href={project.github_url} className="btn btn-secondary" target="_blank" rel="noopener noreferrer">GitHub</a>}
          {project.live_url   && <a href={project.live_url}   className="btn btn-primary"   target="_blank" rel="noopener noreferrer">Live</a>}
        </div>

        <div className="post-body">
          <ReactMarkdown>{project.description}</ReactMarkdown>
        </div>
      </article>
    </main>
  )
}
