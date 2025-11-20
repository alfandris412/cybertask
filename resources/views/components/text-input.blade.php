@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-xl shadow-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300']) !!}>