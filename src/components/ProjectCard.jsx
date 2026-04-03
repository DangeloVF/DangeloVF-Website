import { Link } from 'react-router-dom'
import ReactMarkdown from 'react-markdown'

const TAG_COLOURS = ['tag-cyan', 'tag-magenta', 'tag-yellow']

function previewText(description) {
  const stripped = description
    .replace(/!\[.*?\]\(.*?\)/g, '')
    .replace(/\[([^\]]+)\]\([^\)]+\)/g, '$1')
    .replace(/[*_]{1,2}([^*_\n]+)[*_]{1,2}/g, '$1')
    .replace(/`([^`]+)`/g, '$1')
    .replace(/^#+\s/gm, '')
  const firstPara = stripped.split('\n\n')[0]
  return firstPara.length <= 128 ? firstPara : stripped.slice(0, 128).trimEnd() + '…'
}

export default function ProjectCard({ project, featured = false }) {
  const { title, slug, description, tags: rawTags, github_url, live_url, thumbnail, year } = project
  const tags = typeof rawTags === 'string' ? JSON.parse(rawTags) : (rawTags ?? [])

  if (featured) {
    return (
      <article
        className="card project-featured-card"
        aria-label={`Featured project: ${title}`}
      >
        <div className="card-reveal" aria-hidden="true" />
        <div>
          <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--light-magenta)', letterSpacing: '0.15em', textTransform: 'uppercase', marginBottom: '0.5rem' }}>
            ★ Featured Project {year && `· ${year}`}
          </p>
          <h3 style={{ fontFamily: 'var(--font-display)', fontSize: '2rem', color: 'var(--white)', margin: '0 0 1rem' }}>
            <Link to={`/projects/${slug}`} style={{ color: 'inherit', textDecoration: 'none' }}>{title}</Link>
          </h3>
          <ReactMarkdown>{description}</ReactMarkdown>
          <div className="tags">{tags.map((tag, i) => (
            <span key={tag} className={`tag ${TAG_COLOURS[i % 3]}`}>{tag}</span>
          ))}</div>
          <div style={{ display: 'flex', gap: '1rem' }}>
            {github_url && <a href={github_url} className="btn btn-secondary" target="_blank" rel="noopener noreferrer">GitHub</a>}
            {live_url   && <a href={live_url}   className="btn btn-primary"   target="_blank" rel="noopener noreferrer">Live</a>}
          </div>
        </div>

        {/* Terminal code panel — hidden on mobile via .project-terminal */}
        <div
          aria-hidden="true"
          className="project-terminal"
          style={{ background: '#050508', border: '1px solid rgba(0,245,255,0.15)', padding: '1.25rem', fontFamily: 'var(--font-mono)', fontSize: '0.75rem', lineHeight: 1.8, color: 'var(--dim)', overflow: 'hidden' }}
        >
          <div style={{ marginBottom: '0.5rem', color: 'var(--cyan)' }}>// {title}</div>
          {thumbnail
            ? <img src={thumbnail} alt="" style={{ width: '100%', height: 140, objectFit: 'cover', opacity: 0.8 }} />
            : (
              <>
                <span style={{ color: 'var(--light-magenta)' }}>const</span>
                {' project = {\n  '}
                <span style={{ color: 'var(--yellow)' }}>tags</span>
                {': ['}
                {tags.map((t, i) => <span key={t}><span style={{ color: '#aaffaa' }}>"{t}"</span>{i < tags.length - 1 ? ', ' : ''}</span>)}
                {'],\n  '}
                <span style={{ color: 'var(--yellow)' }}>year</span>
                {`: ${year ?? '??'},\n};`}
              </>
            )
          }
        </div>
      </article>
    )
  }

  return (
    <article className="card" aria-label={`Project: ${title}`} style={{ display: 'flex', flexDirection: 'column' }}>
      <div className="card-reveal" aria-hidden="true" />
      {thumbnail && <img src={thumbnail} alt="" style={{ width: '100%', height: 120, objectFit: 'cover', marginBottom: '1rem', opacity: 0.85 }} />}
      <p className="post-meta" style={{ marginBottom: '0.4rem' }}>{year}</p>
      <h3 style={{ fontFamily: 'var(--font-display)', fontSize: '1.5rem', color: 'var(--white)', margin: '0 0 0.75rem' }}>
        <Link to={`/projects/${slug}`} style={{ color: 'inherit', textDecoration: 'none' }}>{title}</Link>
      </h3>
      <p style={{ color: 'var(--dim)', fontSize: '0.95rem', lineHeight: 1.6, marginBottom: '1rem', flex: 1 }}>
        {previewText(description)}
      </p>
      <div className="tags" style={{ marginBottom: '1rem' }}>{tags.map((tag, i) => (
        <span key={tag} className={`tag ${TAG_COLOURS[i % 3]}`}>{tag}</span>
      ))}</div>
      <div style={{ display: 'flex', gap: '0.75rem' }}>
        {github_url && <a href={github_url} target="_blank" rel="noopener noreferrer" className="card-link text-cyan">GitHub →</a>}
        {live_url   && <a href={live_url}   target="_blank" rel="noopener noreferrer" className="card-link text-magenta">Live →</a>}
        <Link to={`/projects/${slug}`} className="card-link text-yellow">Details →</Link>
      </div>
    </article>
  )
}
