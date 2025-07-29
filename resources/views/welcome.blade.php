<!DOCTYPE html>
<html>
<head>
    <title>Cari Data Santri - TAHFIDZ 57</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            font-family: "Segoe UI", sans-serif; margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed; display: flex; align-items: center;
            justify-content: center; min-height: 100vh; padding: 20px; box-sizing: border-box;
        }
        .search-container {
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2); padding: 40px;
            border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            width: 100%; max-width: 600px; text-align: center;
        }
        .title { margin: 0; font-size: 2.5rem; font-weight: 700; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .subtitle { margin: 5px 0 20px 0; color: rgba(255, 255, 255, 0.9); font-size: 1rem; }
        .search-container p { color: rgba(255, 255, 255, 0.9); }
        .search-form { display: flex; gap: 10px; margin-top: 20px; }
        .search-input {
            flex-grow: 1; padding: 15px; font-size: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 10px;
            background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.2s ease;
        }
        .search-input::placeholder { color: rgba(255, 255, 255, 0.7); }
        .search-input:focus { border-color: #fff; background: rgba(255, 255, 255, 0.3); outline: none; }
        .search-button {
            background: #fff; color: #667eea; border: none; padding: 15px 25px;
            border-radius: 10px; cursor: pointer; font-weight: bold; transition: all 0.2s ease;
        }
        .search-button:hover { background: #f0f0f0; }
        .results-list { list-style: none; padding: 0; margin-top: 30px; text-align: left; max-height: 250px; overflow-y: auto; }
        .results-list li a {
            display: block; padding: 15px; background: rgba(0, 0, 0, 0.2);
            border-radius: 10px; margin-bottom: 10px; text-decoration: none;
            color: #fff; font-weight: 600; transition: all 0.2s ease;
        }
        .results-list li a:hover { background: rgba(0, 0, 0, 0.4); transform: translateX(5px); }
        .admin-link { margin-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 20px; }
        .admin-link a { color: rgba(255, 255, 255, 0.8); text-decoration: none; font-weight: 600; }
        .admin-link a:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="search-container">
        <h1 class="title">TAHFIDZ 57</h1>
        <p class="subtitle">(Ustadz Ikhtirozul Akhyar)</p>
        <p>Masukkan nama santri untuk melihat progres absensi dan hafalannya.</p>
        
        <form method="GET" action="/" class="search-form">
            <input type="text" name="q" class="search-input" placeholder="Ketik nama santri..." value="{{ old('q', $query) }}" required>
            <button type="submit" class="search-button">Cari</button>
        </form>

        @if($query)
            @if($santriList->isEmpty())
                <p style="margin-top:20px; color: #ffdddd;">Santri dengan nama "{{ htmlspecialchars($query) }}" tidak ditemukan.</p>
            @else
                <ul class="results-list">
                    @foreach($santriList as $santri)
                        <li>
                            <a href="{{ route('santri.progres.publik', $santri->id) }}">
                                {{ $santri->nama }} (Kelas {{ $santri->kelas }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
        
        <div class="admin-link">
            <a href="/admin/login">Login sebagai Admin</a>
        </div>
    </div>
</body>
</html>