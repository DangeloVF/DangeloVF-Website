import { Component } from 'react'

export default class ErrorBoundary extends Component {
  constructor(props) {
    super(props)
    this.state = { crashed: false }
  }

  static getDerivedStateFromError() {
    return { crashed: true }
  }

  render() {
    if (this.state.crashed) {
      return (
        <main>
          <section className="section" aria-labelledby="error-heading">
            <p className="section-label">System Error</p>
            <h1
              id="error-heading"
              className="glitch section-title"
              data-text="500"
              style={{ fontSize: 'clamp(4rem, 12vw, 8rem)', marginBottom: '1rem' }}
            >
              500
            </h1>
            <p style={{ fontFamily: 'var(--font-mono)', color: 'var(--dim)', marginBottom: '2rem' }}>
              Something went wrong. Try refreshing the page.
            </p>
            <button className="btn btn-primary" onClick={() => window.location.reload()}>
              Reload
            </button>
          </section>
        </main>
      )
    }

    return this.props.children
  }
}
