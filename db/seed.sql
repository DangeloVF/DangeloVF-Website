-- ─────────────────────────────────────────────────────────────────────────────
-- seed.sql — test data for dangelovf.com
-- Run via phpMyAdmin SQL tab after importing schema.sql
-- ─────────────────────────────────────────────────────────────────────────────


-- ─── bio ─────────────────────────────────────────────────────────────────────
-- 16 draft versions; only id=16 is active (mirrors how the admin panel works)

INSERT INTO bio (name, headline, about, available, cv_file, active) VALUES
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 1\nCS & Electronics graduate.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 2\nCS & Electronics graduate from the University of Bristol.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 3\nMEng graduate. Interested in signal processing and embedded systems.', 'busy', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 4\nBuilding things at the intersection of hardware and software.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 5\nSignal processing, embedded systems, and audio-visual technology.', 'offline', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 6\nI design and build systems that sit at the edge of electronics and code.', 'ready', NULL, 0),
('D''Angelo V. F.', 'MEng Computer Science & Electronics', '## Draft 7\nFirst-class MEng graduate. Focus: DSP, FPGA, real-time systems.', 'ready', NULL, 0),
('D''Angelo V. F.', 'MEng Computer Science & Electronics', '## Draft 8\nI build audio-visual systems, embedded devices, and the occasional website.', 'busy', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 9\nFirst-class MEng from Bristol. Signal processing and audio-visual tech.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 10\nGraduate engineer with a passion for real-time audio, FPGA design, and cyberpunk aesthetics.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 11\nI make things that you can see and hear — from FPGA synthesisers to data-driven visualisers.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 12\nMEng CS & Electronics (Bristol, 2024). Real-time systems, DSP, and creative code.', 'busy', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 13\nI specialise in signal processing, embedded systems, and audio-visual tech.\n\nFirst-class MEng from the University of Bristol.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 14\nSignal processing engineer and creative technologist.\n\nMEng CS & Electronics — University of Bristol, 2024.\n\nI build systems that sit at the intersection of hardware and art.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist', '## Draft 15\nMEng graduate from Bristol with a first. I specialise in DSP, FPGA development, and real-time audio-visual systems — with a taste for cyberpunk aesthetics in everything I make.', 'ready', NULL, 0),
('D''Angelo V. F.', 'Computer Engineer & Cyber Artist',
'MEng Computer Science & Electronics — University of Bristol, 2024. First Class Honours.

I build things at the intersection of **hardware and code** — real-time signal processing pipelines, FPGA synthesisers, embedded sensor systems, and the web interfaces that tie them together.

When I''m not engineering I''m making music and visual art, usually with the same tools.

Currently open to roles in embedded systems, DSP, and audio-visual technology.',
'ready', NULL, 1);


-- ─── skills ──────────────────────────────────────────────────────────────────

INSERT INTO skills (name, category, proficiency, order_index) VALUES
-- Languages
('Python',          'Languages', 92, 1),
('C',               'Languages', 88, 2),
('C++',             'Languages', 82, 3),
('JavaScript',      'Languages', 85, 4),
('PHP',             'Languages', 75, 5),
('MATLAB',          'Languages', 72, 6),
-- Frontend
('React',           'Frontend',  82, 1),
('HTML & CSS',      'Frontend',  90, 2),
('Tailwind CSS',    'Frontend',  78, 3),
-- Backend
('MySQL',           'Backend',   76, 1),
('Node.js',         'Backend',   68, 2),
-- Tools
('Git',             'Tools',     93, 1),
('Linux',           'Tools',     84, 2),
('Docker',          'Tools',     62, 3),
-- Hardware
('Arduino / AVR',   'Hardware',  90, 1),
('FPGA / VHDL',     'Hardware',  74, 2);


-- ─── qualifications ───────────────────────────────────────────────────────────

INSERT INTO qualifications (institution, qualification, grade, year, order_index) VALUES
-- Degrees
('University of Bristol', 'MEng Computer Science & Electronics', 'First Class Honours', 2024, 1),
('University of Bristol', 'BEng Computer Science & Electronics', 'First Class Honours', 2023, 2),
-- A Levels
('Sixth Form College',    'A Level Mathematics',                 'A*',                  2019, 3),
('Sixth Form College',    'A Level Physics',                     'A',                   2019, 4),
('Sixth Form College',    'A Level Computer Science',            'A*',                  2019, 5),
-- GCSEs
('Secondary School',      'GCSE Mathematics',                    '9',                   2017, 6),
('Secondary School',      'GCSE Physics',                        '9',                   2017, 7),
('Secondary School',      'GCSE Computer Science',               '9',                   2017, 8),
('Secondary School',      'GCSE English Language',               '7',                   2017, 9),
('Secondary School',      'GCSE Music',                          '8',                   2017, 10),
-- Online / Professional Certs
('Coursera',              'Machine Learning Specialization',     'Distinction',         2022, 11),
('Coursera',              'Deep Learning Specialization',        'Distinction',         2022, 12),
('Cisco',                 'CCNA — Introduction to Networks',     'Pass',                2021, 13),
('CompTIA',               'Security+',                           'Pass',                2022, 14),
('AWS',                   'Cloud Practitioner',                  'Pass',                2023, 15),
('Udemy',                 'React — The Complete Guide',          'Certificate',         2023, 16);


-- ─── projects ────────────────────────────────────────────────────────────────

INSERT INTO projects (id, title, slug, description, tags, github_url, live_url, thumbnail, featured, year, order_index) VALUES

('11111111-0001-0000-0000-000000000001',
 'Portfolio Website',
 'portfolio-website',
 '## Portfolio Website\n\nThe site you''re looking at. Built with React (Vite) and Tailwind, backed by a PHP + MySQL API, hosted on IONOS.\n\nDesigned around a cyberpunk/retro-terminal aesthetic with custom CSS animations, a scrolling skills ticker, and a full admin CMS.',
 '["React","PHP","MySQL","Tailwind CSS","Vite"]',
 'https://github.com/DangeloVF/dangelovf-site',
 'https://dangelovf.com',
 NULL, 1, 2024, 1),

('11111111-0002-0000-0000-000000000002',
 'FPGA MIDI Synthesiser',
 'fpga-midi-synthesiser',
 '## FPGA MIDI Synthesiser\n\nA polyphonic synthesiser implemented in VHDL on a Xilinx Artix-7 FPGA. Accepts MIDI input via UART, generates up to 8 voices using wavetable synthesis, and outputs audio over I2S to a DAC.\n\nDeveloped as part of my MEng final-year project.',
 '["VHDL","FPGA","MIDI","DSP","Xilinx"]',
 'https://github.com/DangeloVF/fpga-synth',
 NULL,
 NULL, 1, 2024, 2),

('11111111-0003-0000-0000-000000000003',
 'Real-Time Audio Visualiser',
 'audio-visualiser',
 '## Real-Time Audio Visualiser\n\nA browser-based audio visualiser built with the Web Audio API and Canvas. Performs real-time FFT on microphone or file input and renders frequency data as a reactive waveform with a cyberpunk colour palette.',
 '["JavaScript","Web Audio API","Canvas","FFT"]',
 'https://github.com/DangeloVF/audio-visualiser',
 NULL,
 NULL, 1, 2024, 3),

('11111111-0004-0000-0000-000000000004',
 'Embedded Weather Station',
 'embedded-weather-station',
 '## Embedded Weather Station\n\nAn Arduino-based weather station that samples temperature, humidity, pressure, and UV index. Data is logged to an SD card and served over a local web interface via an ESP8266 Wi-Fi module.',
 '["C","Arduino","ESP8266","Sensors","HTML"]',
 'https://github.com/DangeloVF/weather-station',
 NULL,
 NULL, 0, 2023, 4),

('11111111-0005-0000-0000-000000000005',
 'Signal Processing Toolkit',
 'signal-processing-toolkit',
 '## Signal Processing Toolkit\n\nA Python library of DSP utilities: FIR/IIR filter design, windowed FFT, spectrogram generation, and resampling. Designed to complement MATLAB workflows with a fully open-source alternative.',
 '["Python","NumPy","SciPy","DSP"]',
 'https://github.com/DangeloVF/dsp-toolkit',
 NULL,
 NULL, 0, 2023, 5),

('11111111-0006-0000-0000-000000000006',
 'Retro Terminal Emulator',
 'retro-terminal-emulator',
 '## Retro Terminal Emulator\n\nA CRT-style terminal emulator built in Electron. Features scanline and phosphor-glow shaders applied via WebGL, a custom shell with a handful of built-in commands, and configurable colour palettes.',
 '["Electron","JavaScript","WebGL","GLSL"]',
 'https://github.com/DangeloVF/retro-term',
 NULL,
 NULL, 0, 2023, 6),

('11111111-0007-0000-0000-000000000007',
 'Neural Network from Scratch',
 'neural-network-scratch',
 '## Neural Network from Scratch\n\nA fully-connected neural network implemented in pure Python and NumPy — no frameworks. Supports configurable layers, ReLU/sigmoid activations, mini-batch SGD, and dropout. Benchmarked on MNIST.',
 '["Python","NumPy","Machine Learning"]',
 'https://github.com/DangeloVF/nn-scratch',
 NULL,
 NULL, 0, 2022, 7),

('11111111-0008-0000-0000-000000000008',
 'Raspberry Pi Home Automation',
 'rpi-home-automation',
 '## Raspberry Pi Home Automation\n\nA home automation hub running on a Raspberry Pi 4. Controls lighting, reads environmental sensors, and exposes a simple web dashboard. Uses MQTT for device communication and stores time-series data in InfluxDB.',
 '["Python","Raspberry Pi","MQTT","InfluxDB","HTML"]',
 'https://github.com/DangeloVF/rpi-home',
 NULL,
 NULL, 0, 2022, 8),

('11111111-0009-0000-0000-000000000009',
 'Computer Vision Hand Tracker',
 'hand-tracker',
 '## Computer Vision Hand Tracker\n\nReal-time hand landmark tracking using MediaPipe and OpenCV. Maps finger positions to MIDI CC values, turning hand gestures into a wireless instrument controller.',
 '["Python","OpenCV","MediaPipe","MIDI"]',
 'https://github.com/DangeloVF/hand-tracker',
 NULL,
 NULL, 0, 2023, 9),

('11111111-0010-0000-0000-000000000010',
 'DSP Audio Effects Plugin',
 'dsp-audio-plugin',
 '## DSP Audio Effects Plugin\n\nA VST3/AU plugin built with the JUCE framework implementing a stereo convolution reverb and a tape-saturation distortion model. Written in C++ with a custom UI drawn using JUCE''s Graphics API.',
 '["C++","JUCE","DSP","VST3","Audio"]',
 'https://github.com/DangeloVF/dsp-plugin',
 NULL,
 NULL, 0, 2024, 10),

('11111111-0011-0000-0000-000000000011',
 'Real-Time Chat App',
 'realtime-chat',
 '## Real-Time Chat App\n\nA lightweight chat application using Node.js, Socket.IO, and React. Supports multiple named rooms, typing indicators, and message history stored in SQLite. Deployed on a DigitalOcean droplet.',
 '["Node.js","Socket.IO","React","SQLite"]',
 'https://github.com/DangeloVF/realtime-chat',
 NULL,
 NULL, 0, 2022, 11),

('11111111-0012-0000-0000-000000000012',
 'VHDL CPU Core',
 'vhdl-cpu-core',
 '## VHDL CPU Core\n\nA simple 16-bit RISC CPU designed in VHDL and simulated in ModelSim. Implements a 5-stage pipeline (fetch, decode, execute, memory, writeback) with a custom instruction set and an assembler written in Python.',
 '["VHDL","FPGA","Computer Architecture","Python"]',
 'https://github.com/DangeloVF/vhdl-cpu',
 NULL,
 NULL, 0, 2023, 12),

('11111111-0013-0000-0000-000000000013',
 'Music Recommendation Engine',
 'music-recommendation',
 '## Music Recommendation Engine\n\nA content-based music recommendation system that extracts MFCC, chroma, and spectral features from audio files and clusters tracks using k-means. Built as a coursework project for a machine learning module.',
 '["Python","Librosa","scikit-learn","Machine Learning"]',
 'https://github.com/DangeloVF/music-rec',
 NULL,
 NULL, 0, 2022, 13),

('11111111-0014-0000-0000-000000000014',
 'Cyberpunk UI Component Library',
 'cyberpunk-ui',
 '## Cyberpunk UI Component Library\n\nA small React component library with a retro-terminal aesthetic. Includes glitch text, CRT scanline overlays, neon progress bars, and a data ticker. Published to npm.',
 '["React","CSS","npm","Component Library"]',
 'https://github.com/DangeloVF/cyberpunk-ui',
 NULL,
 NULL, 0, 2024, 14),

('11111111-0015-0000-0000-000000000015',
 'AR Music Visualiser',
 'ar-music-visualiser',
 '## AR Music Visualiser\n\nAn augmented reality music visualiser built with Unity and AR Foundation. Detects a marker card and renders a 3D frequency-reactive particle system anchored to it in world space.',
 '["Unity","C#","AR Foundation","Audio","Shaders"]',
 'https://github.com/DangeloVF/ar-visualiser',
 NULL,
 NULL, 0, 2023, 15),

('11111111-0016-0000-0000-000000000016',
 'Blockchain Voting Prototype',
 'blockchain-voting',
 '## Blockchain Voting Prototype\n\nA proof-of-concept voting system on a private Ethereum chain using Solidity smart contracts and a React front end (ethers.js). Built for a university security module to explore tamper-evident record-keeping.',
 '["Solidity","Ethereum","React","ethers.js"]',
 'https://github.com/DangeloVF/blockchain-vote',
 NULL,
 NULL, 0, 2022, 16);


-- ─── posts ───────────────────────────────────────────────────────────────────

INSERT INTO posts (id, title, slug, excerpt, body, tags, featured, year, order_index, published, published_on) VALUES

('22222222-0001-0000-0000-000000000001',
 'Building a Real-Time Audio Visualiser in the Browser',
 'real-time-audio-visualiser',
 'The Web Audio API makes real-time FFT surprisingly accessible. Here''s how I built a frequency-reactive visualiser with nothing but vanilla JavaScript and a Canvas element.',
 '# Building a Real-Time Audio Visualiser in the Browser\n\nThe Web Audio API is one of those browser APIs that feels almost too powerful for something that ships in every modern browser. This post walks through building a simple real-time visualiser that reads microphone input, performs an FFT, and renders the frequency data as a bar graph.\n\n## Setting up the AudioContext\n\n```js\nconst ctx = new AudioContext()\nconst analyser = ctx.createAnalyser()\nanalyser.fftSize = 2048\n```\n\nOnce you have an analyser node, you connect it between your source and the destination, then read from it on every animation frame using `getByteFrequencyData`.',
 '["JavaScript","Web Audio API","FFT","Canvas"]',
 1, 2024, 1, 1, '2024-03-15 10:00:00'),

('22222222-0002-0000-0000-000000000002',
 'Getting Started with FPGA Development',
 'getting-started-fpga',
 'FPGAs can be intimidating but the fundamentals are simpler than they look. This is the intro I wish I had when I first opened Vivado.',
 '# Getting Started with FPGA Development\n\nThe first time I opened Xilinx Vivado I closed it again within ten minutes. The toolchain is enormous, the terminology is unfamiliar, and the feedback loop feels nothing like writing software.\n\nThis post covers what I actually needed to understand before things clicked.\n\n## What an FPGA actually is\n\nA field-programmable gate array is a chip full of configurable logic blocks (CLBs) wired together via a programmable interconnect. You describe the circuit you want in a hardware description language (VHDL or Verilog), synthesise it, and the toolchain maps your design onto the physical fabric.\n\nYou are not writing code that runs on a processor — you are *describing hardware*.',
 '["FPGA","VHDL","Hardware","Xilinx"]',
 0, 2024, 2, 1, '2024-04-02 14:30:00'),

('22222222-0003-0000-0000-000000000003',
 'Signal Processing 101: What is a Fourier Transform?',
 'what-is-fourier-transform',
 'Every audio engineer and DSP developer uses the FFT constantly, but the underlying maths is elegant enough to be worth understanding properly.',
 '# Signal Processing 101: What is a Fourier Transform?\n\nThe Fourier transform is one of those mathematical tools that shows up everywhere once you start looking — audio processing, image compression, wireless communications, medical imaging. This post gives an intuitive explanation without drowning in notation.\n\n## The core idea\n\nAny periodic signal can be decomposed into a sum of sine waves of different frequencies and amplitudes. The Fourier transform tells you *which* frequencies are present and at *what amplitude*.\n\nFor a time-domain signal x(t), the transform gives you a frequency-domain representation X(f).',
 '["DSP","Mathematics","FFT","Audio"]',
 0, 2024, 3, 1, '2024-04-20 09:15:00'),

('22222222-0004-0000-0000-000000000004',
 'Why I Chose PHP for My Backend',
 'why-i-chose-php',
 'PHP gets a bad reputation that largely belongs to a decade-old version of itself. Here''s why it was the right call for this project.',
 '# Why I Chose PHP for My Backend\n\nWhenever I mention that this site runs on PHP I get a raised eyebrow. Fair enough — PHP circa 2008 was a mess. But modern PHP (8.x) is a genuinely pleasant language for building small API backends, and for IONOS shared hosting it''s the obvious default.\n\n## The actual reasons\n\n1. **It''s already there.** IONOS WebHosting Plus runs Apache + PHP. No config, no runtime to install, no Docker containers.\n2. **PDO is solid.** Parameterised queries, proper error handling, and it works identically on MariaDB locally and MySQL in production.\n3. **The deployment story is unbeatable.** FTP a file and it''s live.',
 '["PHP","Backend","IONOS","Architecture"]',
 0, 2024, 4, 1, '2024-05-05 11:00:00'),

('22222222-0005-0000-0000-000000000005',
 'Cyberpunk Aesthetics in Web Design',
 'cyberpunk-web-design',
 'Neon on black, glitchy typography, and terminal UIs — here''s how I translated the cyberpunk aesthetic into a real design system without it becoming a parody of itself.',
 '# Cyberpunk Aesthetics in Web Design\n\nCyberpunk as a visual style is easy to do badly. Slap some neon on a dark background, add a few scanlines, call it done. The result usually looks like a Halloween costume rather than a considered design.\n\nBuilding this portfolio forced me to think about what the aesthetic is *actually* communicating and how to do it with restraint.\n\n## The palette\n\nI landed on three accent colours against a near-black background:\n\n- **Cyan `#00f5ff`** — primary, interactive elements, code\n- **Magenta `#ff00aa`** — error states, emphasis\n- **Yellow `#ffe500`** — warnings, secondary highlights',
 '["Design","CSS","Cyberpunk","Portfolio"]',
 0, 2024, 5, 1, '2024-05-18 16:45:00'),

('22222222-0006-0000-0000-000000000006',
 'Embedded Systems with Arduino: Beyond Blink',
 'arduino-beyond-blink',
 'Most Arduino tutorials stop at blinking an LED. This post covers the things that actually matter when you''re building something real.',
 '# Embedded Systems with Arduino: Beyond Blink\n\nThe first thing every Arduino tutorial teaches you is how to blink an LED. It''s a fine sanity check, but it teaches you almost nothing about writing embedded software that actually works.\n\nHere are the topics that matter once you go further.\n\n## Interrupts vs polling\n\nPolling a sensor in `loop()` works fine until you need to do something else at the same time. Hardware interrupts let the MCU respond to an event immediately, without burning cycles checking a flag.',
 '["Arduino","Embedded","C","Hardware"]',
 0, 2023, 6, 1, '2023-11-10 08:30:00'),

('22222222-0007-0000-0000-000000000007',
 'CSS Animations That Actually Perform Well',
 'css-animations-performance',
 'Most CSS animation performance advice boils down to "use transform and opacity". Here''s why, and a few less obvious things worth knowing.',
 '# CSS Animations That Actually Perform Well\n\nThe standard advice for CSS animation performance is: only animate `transform` and `opacity`. This is good advice but it helps to understand *why*.\n\n## The browser rendering pipeline\n\nFor most CSS properties, changing a value triggers a full recalculate → layout → paint → composite cycle. `transform` and `opacity` skip directly to the compositing step because the browser can hand them off to the GPU without reflowing the document.',
 '["CSS","Performance","Animation","Frontend"]',
 0, 2024, 7, 1, '2024-06-01 13:00:00'),

('22222222-0008-0000-0000-000000000008',
 'Making Music with Code',
 'making-music-with-code',
 'From MIDI controllers built out of cardboard to VST plugins in JUCE — my experience at the intersection of music and engineering.',
 '# Making Music with Code\n\nI''ve been making music for about as long as I''ve been writing code, so it was inevitable that the two would merge. This post is a loose account of how that''s gone.\n\n## Starting point: MIDI\n\nMIDI is a remarkably durable protocol. Designed in 1983, it''s still the universal language of digital music hardware. A MIDI message is just a few bytes: note on/off, pitch, velocity, control change. Simple to generate from a microcontroller, easy to route into a DAW.',
 '["Music","MIDI","JUCE","Audio","Creative Code"]',
 0, 2024, 8, 1, '2024-06-14 10:00:00'),

('22222222-0009-0000-0000-000000000009',
 'My Final Year at Bristol',
 'final-year-bristol',
 'Reflections on finishing an MEng in Computer Science & Electronics — the thesis, the team project, and what I''d do differently.',
 '# My Final Year at Bristol\n\nFourth year of an MEng is a significant step up. The taught content is mostly gone; it''s mostly project work and individual research.\n\n## The individual project\n\nI built an FPGA-based MIDI synthesiser — a polyphonic wavetable synth implemented in VHDL on a Xilinx Artix-7. The project ran the full cycle: literature review, architecture design, RTL implementation, simulation, hardware bring-up, and final evaluation.\n\nIt is the most technically demanding thing I''ve done, and also the most satisfying.',
 '["University","Bristol","FPGA","Reflection"]',
 0, 2024, 9, 1, '2024-07-01 09:00:00'),

('22222222-0010-0000-0000-000000000010',
 'VHDL vs Verilog: Which Should You Learn?',
 'vhdl-vs-verilog',
 'Both are industry-standard HDLs. Here''s an honest comparison for someone choosing which one to start with.',
 '# VHDL vs Verilog: Which Should You Learn?\n\nIf you''re getting into FPGA development the first question is usually which hardware description language to pick. Both VHDL and Verilog (or its superset SystemVerilog) will get you to the same place. The differences are real but not enormous.\n\n## VHDL\n\nMore verbose, more strongly typed, and more common in European academia and defence/aerospace. The extra verbosity forces you to be explicit about types, which catches a lot of bugs at compile time.',
 '["VHDL","Verilog","FPGA","Hardware"]',
 0, 2024, 10, 1, '2024-07-20 14:00:00'),

('22222222-0011-0000-0000-000000000011',
 'Building a VST Plugin with JUCE',
 'building-vst-juce',
 'JUCE is the de facto framework for audio plugins. Here''s what the development experience is actually like and the gotchas I hit first time.',
 '# Building a VST Plugin with JUCE\n\nJUCE is a C++ framework that handles almost everything a plugin needs: audio buffer management, parameter automation, a UI toolkit, and the boilerplate that wraps your code into a VST3/AU/AAX binary.\n\n## The mental model\n\nYour plugin lives inside an `AudioProcessor` subclass. The host calls `processBlock()` on the audio thread with an input/output buffer. You read, process, and write. That''s the core loop.',
 '["C++","JUCE","VST","Audio","DSP"]',
 0, 2024, 11, 1, '2024-08-05 11:30:00'),

('22222222-0012-0000-0000-000000000012',
 'Getting into Machine Learning as a Hardware Engineer',
 'ml-for-hardware-engineers',
 'Most ML tutorials assume a software background. Here''s how the concepts map if you''re coming from electronics and signal processing.',
 '# Getting into Machine Learning as a Hardware Engineer\n\nIf your background is electronics or embedded systems rather than software, ML tutorials can feel oddly familiar and strangely foreign at the same time. The maths overlaps significantly with signal processing; the tooling and vocabulary do not.\n\n## The overlap\n\nA neuron is essentially a linear filter followed by a non-linearity. Backpropagation is gradient descent, which you may have seen in control theory. Convolutions in CNNs are the same operation as in DSP — just applied to 2D data.',
 '["Machine Learning","DSP","Python","Engineering"]',
 0, 2024, 12, 1, '2024-08-22 09:45:00'),

('22222222-0013-0000-0000-000000000013',
 'How React''s useEffect Actually Works',
 'how-useeffect-works',
 'useEffect is one of the most commonly misunderstood hooks. Here''s a mental model that actually holds up.',
 '# How React''s useEffect Actually Works\n\n`useEffect` trips up almost everyone who comes to React from a class-component background or from outside React entirely. The lifecycle framing ("this runs on mount, this runs on update") is technically accurate but leads to confusing code.\n\n## The better mental model\n\nThink of `useEffect` as *synchronising an external system with the current render output*, not as a lifecycle hook. Your effect declares: "given this state, the outside world should look like this."',
 '["React","JavaScript","Hooks","Frontend"]',
 0, 2024, 13, 1, '2024-09-10 10:00:00'),

('22222222-0014-0000-0000-000000000014',
 'Deploying a Static Site to IONOS',
 'deploying-to-ionos',
 'IONOS shared hosting isn''t glamorous, but for a PHP + static site combo it''s perfectly good. Here''s the deployment setup that works.',
 '# Deploying a Static Site to IONOS\n\nIONOS WebHosting Plus is not the most exciting hosting platform, but it covers exactly what this site needs: Apache, PHP 8.x, MySQL 8, and enough storage for a portfolio. No Docker, no CI/CD pipelines.\n\n## The workflow\n\n1. `npm run build` — Vite bundles React into `/dist`\n2. FTP `/dist/*` to the web root\n3. FTP `/api/*` to `/api/`\n4. FTP `/admin/*` to `/admin/`\n\nEnvironment variables (DB credentials, admin password hash) live in the IONOS control panel.',
 '["Deployment","IONOS","PHP","FTP","DevOps"]',
 0, 2024, 14, 1, '2024-09-28 15:00:00'),

('22222222-0015-0000-0000-000000000015',
 'Designing a CMS for a Solo Developer',
 'cms-for-solo-developer',
 'Building your own admin panel instead of reaching for WordPress or a headless CMS. When it makes sense and how I approached it.',
 '# Designing a CMS for a Solo Developer\n\nWhen I decided to build a blog into this portfolio the obvious choice was to reach for a headless CMS — Contentful, Sanity, Strapi. I built my own instead.\n\n## Why roll your own?\n\nThe main reason: I wanted full control over the schema without a third-party service sitting between my site and my data. Secondary reason: I wanted to build it.\n\nThe requirements were simple enough that a custom panel made sense: create/edit/delete posts and projects, upload images, manage bio content.',
 '["PHP","CMS","Architecture","Admin","MySQL"]',
 0, 2024, 15, 1, '2024-10-15 12:00:00'),

('22222222-0016-0000-0000-000000000016',
 'The Future of Audio-Visual Technology',
 'future-audio-visual-tech',
 'Where real-time audio-visual technology is heading — spatial audio, AI-generated visuals, and the blurring line between instrument and environment.',
 '# The Future of Audio-Visual Technology\n\nAudio-visual technology has been on an accelerating curve since the early synthesiser era. The tools available to a solo artist or engineer today would have required an entire production facility thirty years ago.\n\n## Spatial audio\n\nBinaural rendering, ambisonics, and object-based audio formats (Dolby Atmos, Sony 360 Reality Audio) are making spatial audio mainstream. The challenge for real-time applications is the computational cost of accurate HRTF convolution — something that FPGAs and dedicated DSP chips handle particularly well.\n\n## AI and generative visuals\n\nDiffusion models have made high-quality image synthesis accessible in real time. The interesting creative space is not AI replacing the artist but AI as a reactive instrument — visuals that respond to audio, gesture, or environmental data.',
 '["Audio","Visual","Technology","Future","AI"]',
 1, 2024, 16, 1, '2024-11-01 10:00:00');
