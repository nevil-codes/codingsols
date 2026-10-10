<?php

// Vercel serverless entry point: every request that isn't a static file
// in public/ is routed here (see vercel.json).
require __DIR__.'/../public/index.php';
