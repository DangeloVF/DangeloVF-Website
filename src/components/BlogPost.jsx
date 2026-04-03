import { useState, useEffect } from 'react'
import { useParams, Link } from 'react-router-dom'
import ReactMarkdown from 'react-markdown'
import { api } from '../lib/api'

export default function BlogPost() {
  const { slug }                = useParams()
  const [post, setPost]         = useState(null)
  const [loading, setLoading]   = useState(true)
  const [notFound, setNotFound] = useState(false)

  useEffect(() => {
    api.getPost(slug)
      .then(data => {
        if (!data) setNotFound(true)
        else setPost(data)
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
          <p role="alert">Post not found.</p>
          <Link to="/blog" className="back-link">← Back to blog</Link>
        </section>
      </main>
    )
  }

  const tags = typeof post.tags === 'string' ? JSON.parse(post.tags) : (post.tags ?? [])

  return (
    <main>
      <article className="section" aria-labelledby="post-heading">
        <Link to="/blog" className="back-link">← Back to blog</Link>

        {post.thumbnail && <img src={post.thumbnail} alt="" className="post-thumb" />}

        <p className="post-meta">
          {post.published_on
            ? new Date(post.published_on).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' })
            : post.year}
        </p>

        <h1 id="post-heading" className="post-title">{post.title}</h1>

        {tags.length > 0 && (
          <div className="tags">
            {tags.map((tag, i) => (
              <span key={tag} className={`tag ${['tag-cyan', 'tag-magenta', 'tag-yellow'][i % 3]}`}>{tag}</span>
            ))}
          </div>
        )}

        <div className="post-body">
          <ReactMarkdown>{post.body}</ReactMarkdown>
        </div>
      </article>
    </main>
  )
}
