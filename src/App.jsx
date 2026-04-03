import { HashRouter, Routes, Route } from 'react-router-dom'
import { useEffect } from 'react'
import Nav from './components/Nav'
import Hero from './components/Hero'
import Ticker from './components/Ticker'
import Projects from './components/Projects'
import Skills from './components/Skills'
import Qualifications from './components/Qualifications'
import About from './components/About'
import Contact from './components/Contact'
import Footer from './components/Footer'
import BlogIndex from './components/BlogIndex'
import BlogPost from './components/BlogPost'
import ProjectPage from './components/ProjectPage'
import NotFound from './components/NotFound'
import ErrorBoundary from './components/ErrorBoundary'

function StandaloneMain({ children }) {
  return <main className="standalone-main">{children}</main>
}

function Home() {
  return (
    <main>
      <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
        <Hero />
        <Ticker />
      </div>
      <About />
      <Projects preview />
      <Skills />
      <Qualifications preview />
      <BlogIndex preview />
      <Contact />
    </main>
  )
}

export default function App() {
  useEffect(() => {
    const selector = '.card, .section-title, .section-label'
    const io = new IntersectionObserver(
      entries => entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target) }
      }),
      { threshold: 0.1 }
    )
    const scan = () => document.querySelectorAll(`${selector}:not(.is-visible)`).forEach(el => io.observe(el))
    scan()
    const mo = new MutationObserver(scan)
    mo.observe(document.body, { childList: true, subtree: true })
    return () => { io.disconnect(); mo.disconnect() }
  }, [])

  return (
    <HashRouter>
      <ErrorBoundary>
        <Nav />
        <Routes>
          <Route path="/"                element={<Home />} />
          <Route path="/about"           element={<StandaloneMain><About /></StandaloneMain>} />
          <Route path="/projects"        element={<StandaloneMain><Projects /></StandaloneMain>} />
          <Route path="/projects/:slug"  element={<ProjectPage />} />
          <Route path="/skills"          element={<StandaloneMain><Skills /></StandaloneMain>} />
          <Route path="/qualifications"  element={<StandaloneMain><Qualifications /></StandaloneMain>} />
          <Route path="/contact"         element={<StandaloneMain><Contact /></StandaloneMain>} />
          <Route path="/blog"            element={<StandaloneMain><BlogIndex /></StandaloneMain>} />
          <Route path="/blog/:slug"      element={<BlogPost />} />
          <Route path="*"               element={<NotFound />} />
        </Routes>
        <Footer />
      </ErrorBoundary>
    </HashRouter>
  )
}
