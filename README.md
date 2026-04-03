
# D'Angelo V. F.? Who?

That's me :D I'm a computer engineer by trade and this website is meant to act as a portfolio for all of my projects, ideas, and thoughts!

**This website is live at:** <https://dangelovf.com>

## Why bother?

Why not? I really don't like web development. There are so many frameworks, and tools, and plugins, and all sorts involved. Everyone's got an opinion on them (though find me anything where people don't get overly tribal), and that leads to major decision paralysis. This is me getting over that, trying to do something outside my technological comfort zone.

Also, it feels like in order to find work nowadays, whether that be a full-time job or a freelance gig, you need to be some sort of niche micro-influencer with 10k followers that posts some sort of opinion piece daily. That really isn't me. I have social media, but I just use it to send memes to friends. Even putting this website on GitHub is weird for me. I'd like to change that. Less so for impressing recruiters and employers (though that is a bonus) and more so because I feel like posting about my projects on wherever will motivate me to actively complete them, and not just have them as a few pages in an old notebook.

## What's with the design?

I like it, this website is first and foremost a reflection of me. I wouldn't have enjoyed coding this site if I didn't enjoy how it looked, and then I probably wouldn't have had a website to begin with because I wouldn't have bothered even starting.

I've always been into tech and when I was a teenager I started getting into alternative and countercultural movements, and now I'm a bit older I'm still into them. I told my mum it wasn't a phase.

Some design notes: it's got a cyberpunk/retro aesthetic but I actually toned it down some. Most of the colours are based around CGA colours, specifically the light ones because they're so bright and saturated, I think it adds a nice pop. I used to have this CRT effect on the whole page but that really hurt readability so I got rid of it, using the little + grid and watermarks to add visual interest instead. I also added some fun lil easter eggs if you can find them, because who doesn't love a nice surprise.

## What does the tech stack look like? I bet it's really complicated and cutting-edge

Nah not really :') The website is literally a portfolio so there's nothing crazy going on. I could've done it as a static site if I really wanted to, but since this is gonna be a portfolio piece too, I thought I may as well jazz it up.

Also, as I said, web development isn't something I enjoy. So while this was a fun little project to test my skills, don't expect anything particularly interesting.

### The full tech stack (and some explanations)

For context: I already hosted my old placeholder website using an IONOS windows server (back when I wanted to make this site an ASP.NET site). I didn't really wanna mess about with migrating everything since I still use the email space regularly, hence that helped make most of the decisions here.

- Frontend:
  - React (duh!)
    - I probably could (should) have used some other framework like Vue or Svelte, that may have been way easier, but I'm still starting out in web development as a whole and React is seen as the industry standard so, might as well right?
  - Vite, to help with React
    - Ok, I'm not that masochistic. Yes I chose one of the most difficult frameworks to begin with, but I also chose an easy build system. Vite is nice since there was pretty much no messing about with configuration settings and the like, just run it and it works.
  - TailwindCSS
    - There's not too much to say about this. I could have used something like Bootstrap or even the W3Schools CSS framework, but then I would have gotten something that looks like every other modern website. Ever. Even still, the use of Tailwind is minor at best, pretty much just for its nav and utility classes. Most of the styling is custom so I could make a page which actually reflects who I am!
- Backend:
  - PHP X(
    - Ok, before anyone says anything. I know PHP has a bad rep amongst most professionals. It's horrendously inconsistent, and it's so easy to code horrendously bad and insecure apps. BUT (and it's a big but) it's so fast and easy to code in. Also there's a lot of legacy behind it so many of the issues before with security have been at least worked around. Also before doing this I'd never written a single line of PHP so, why not learn a new programming language too?
- Database:
  - MySQL
    - It's the database that's available on IONOS. I don't really need anything else (hell, I didn't even use any relational aspects)

## Some code things I'm proud of

### The glitch effect!

You notice that VHS-like glitch effect on my name and the error pages? That's really simple. It's basically 2 pseudo-element copies of the text, using `clip-path` to slice different horizontal strips of each on every frame. One of them is solid cyan and the other fades between cyan and magenta, both have little translations in the animation too which I feel adds to the effect.

### Tick, tick, tick

You see that little ticker at the bottom of the screen? Yeah it wasn't that difficult to code, but I'm still proud of it! The most difficult part was having it loop nicely when it ran out of skills, but I've got so many skills it will never run out B). Also, it has a fun little error state if it ever can't get to my databases.

It's probably worth noting too that all animations are disabled when the browser is in reduced motion mode, accessibility is important! (Though the page isn't very colourblind friendly)

### Security features

While not exposed publicly, the website has an admin panel so I can add posts, change my bio, things of that nature. This panel follows the styling of the website (for the sake of consistency) and *should* follow basic security practices. There's HTML input sanitisation, session based login (which I didn't know PHP could do without packages), and even password hashing and salting. The hash and username are environment variables, so you can't get your grubby mitts on them and try to crack them. Did I need to do all of this? Probably not. Password hashing and storing in the environment variables is a given. Session log in and input sanitisation was probably overkill for a page only I would ever use, but better safe than sorry! Could I have done more? Absolutely. 2FA comes to mind first and foremost, but again this is a basic portfolio that only I would ever edit. It would be too much work to implement it IMO.

## Did you use AI?

AI is a heavy topic, I know. It's wrapped in so much controversy. There are so many socio-economic and ethical issues surrounding it, from environmental issues to privacy issues. Tech bros don't help either, trying to claim it's going to "replace everyone's jobs" and being very thoughtless with how they train and deploy models.

I've been enamoured with deep learning though for a long time. My A-Level CS project was making an LSTM m odel that tried (and failed) to predict the market. I use AI tools to help me with my learning disabilities too. If it weren't for them, my master's dissertation would have been a mess of spelling mistakes and grammatical inconsistencies. I'm convinced that, in the right hands and with enough education, LLMs and deep learning models as a whole can be very powerful tools. But that's what they have been and always should be, a tool. Neither intended to replace us, destroy us, or to divide us, but to help us. That's why, unless work on a project that explicitly involves me training a model or leveraging AI in some way, I won't be very vocal about it. For the most part, what I say here is probably all I'll say about how I use AI in my workflow, so congrats on finding it!

To come clean, yes, I did use Claude Code to help me with this. All the important code: the password handling and session management, the base styling and the glitch animation, the general layout, etc. was written by me, by hand. Claude just helped me along, writing SQL queries, refactoring and formatting my code, applying styles to HTML, helping me plan and test, and overall just being a rubber ducky that could speak back to me. Anything Claude wrote I checked thoroughly though, and I didn't let it write anything I didn't understand. Don't worry, it didn't replace Reddit or Stack Overflow for me either.

P.S. This whole readme was written by hand too! (OK, yes, I did use Claude to do a quick spelling and grammar check, but nothing more)
