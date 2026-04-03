import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import ReactMarkdown from 'react-markdown'
import { api } from '../lib/api'

export default function BlogIndex({ preview = false }) {
  const [posts, setPosts]     = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)

  useEffect(() => {
    api.getPosts()
      .then(setPosts)
      .catch(() => setError('Could not load posts.'))
      .finally(() => setLoading(false))
  }, [])

  const visible = preview ? posts.slice(0, 4) : posts

  return (
    <section className="section" aria-labelledby="blog-heading">
      <p className="section-label">05. Writing</p>
      <h2 id="blog-heading" className="section-title">
        <span className="section-number">{'>'}</span> Blog
      </h2>

      {loading  && <p className="loading-text">Loading...</p>}
      {error    && <p role="alert">{error}</p>}
      {!loading && !error && posts.length === 0 && <p className="loading-text">No posts yet.</p>}

      <div style={{ display: 'flex', flexDirection: 'column', gap: '2rem' }}>
        {visible.map(post => (
          <article key={post.id} className="card">
            <div className="card-reveal" aria-hidden="true" />
            {post.thumbnail && (
              <img
                src={post.thumbnail}
                alt=""
                style={{ width: '100%', height: 180, objectFit: 'cover', marginBottom: '1.25rem', opacity: 0.85 }}
              />
            )}
            <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--dim)', letterSpacing: '0.1em', marginBottom: '0.4rem' }}>
              {post.published_on ? new Date(post.published_on).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' }) : post.year}
            </p>
            <h3 style={{ fontFamily: 'var(--font-display)', fontSize: '1.8rem', color: 'var(--white)', margin: '0 0 0.75rem' }}>
              <Link to={`/blog/${post.slug}`} style={{ color: 'inherit', textDecoration: 'none' }}>
                {post.title}
              </Link>
            </h3>
            {post.excerpt && (
              <div style={{ color: 'var(--dim)', fontSize: '0.95rem', lineHeight: 1.7, marginBottom: '1rem' }}>
                <ReactMarkdown components={{ img: () => null }}>{post.excerpt}</ReactMarkdown>
              </div>
            )}
            <Link
              to={`/blog/${post.slug}`}
              style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--cyan)', textDecoration: 'none' }}
            >
              Read more →
            </Link>
          </article>
        ))}
      </div>

      {preview && !loading && !error && posts.length > 4 && (
        <div style={{ marginTop: '2rem' }}>
          <Link to="/blog" className="btn btn-secondary">View All Posts</Link>
        </div>
      )}
      <span aria-hidden="true" className="section-watermark">.05</span>
    </section>
  )
}
