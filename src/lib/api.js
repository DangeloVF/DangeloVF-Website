/**
 * API client — all data fetching goes through here.
 * To swap the backend (e.g. to Rust, Node, etc.) only this file needs changing.
 */

const BASE = import.meta.env.VITE_API_BASE ?? '/api'

async function get(endpoint) {
  const res = await fetch(`${BASE}/${endpoint}`)
  if (!res.ok) throw new Error(`API error ${res.status}: ${endpoint}`)
  return res.json()
}

export const api = {
  getBio:             () => get('bio.php'),
  getProjects:        () => get('projects.php'),
  getProject:         (slug) => get(`projects.php?slug=${encodeURIComponent(slug)}`),
  getSkills:          () => get('skills.php'),
  getPosts:           () => get('posts.php'),
  getPost:            (slug) => get(`posts.php?slug=${encodeURIComponent(slug)}`),
  getQualifications:  () => get('qualifications.php')
}
