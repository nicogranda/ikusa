#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import sys
import json
import urllib.request
import urllib.parse

def get_suggestions(query, lang='es', country='es'):
    params = urllib.parse.urlencode({
        'client': 'firefox',
        'hl': lang,
        'gl': country,
        'q': query
    })
    url = 'https://suggestqueries.google.com/complete/search?' + params
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, timeout=5) as r:
        data = json.loads(r.read().decode('utf-8'))
        return data[1] if len(data) > 1 else []

def build_queries(niche, city='', province='', country_name=''):
    queries = []
    
    # Genéricas nacionales
    queries.append(niche)
    queries.append('agencia ' + niche)
    queries.append('empresa ' + niche)
    queries.append('servicio ' + niche)
    queries.append('mejor ' + niche)
    queries.append(niche + ' profesional')
    queries.append(niche + ' precio')
    queries.append('cuanto cuesta ' + niche)
    
    # Por provincia
    if province:
        queries.append(niche + ' ' + province)
        queries.append('agencia ' + niche + ' ' + province)
        queries.append('empresa ' + niche + ' en ' + province)
    
    # Por ciudad
    if city:
        queries.append(niche + ' ' + city)
        queries.append('agencia ' + niche + ' ' + city)
        queries.append('empresa ' + niche + ' en ' + city)
        queries.append('mejor ' + niche + ' ' + city)
        queries.append(niche + ' a domicilio ' + city)
    
    return queries

def main():
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'Faltan parámetros'}))
        sys.exit(1)
    
    niche    = sys.argv[1] if len(sys.argv) > 1 else ''
    city     = sys.argv[2] if len(sys.argv) > 2 else ''
    province = sys.argv[3] if len(sys.argv) > 3 else ''
    lang     = sys.argv[4] if len(sys.argv) > 4 else 'es'
    country  = sys.argv[5] if len(sys.argv) > 5 else 'es'

    queries  = build_queries(niche, city, province)
    
    results = {'generic': [], 'geolocal': []}
    seen = set()

    for q in queries:
        try:
            suggestions = get_suggestions(q, lang, country)
            is_geo = bool(city and city.lower() in q.lower()) or \
                     bool(province and province.lower() in q.lower())
            
            for s in suggestions:
                s = s.strip()
                if s and s not in seen:
                    seen.add(s)
                    if is_geo:
                        results['geolocal'].append(s)
                    else:
                        results['generic'].append(s)
        except Exception as e:
            continue

    print(json.dumps(results, ensure_ascii=False))

if __name__ == '__main__':
    main()
