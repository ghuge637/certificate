import React, { useState, useEffect } from 'react';

export default function StudentDashboard({ user, onLogout }) {
  const [bonafideReason, setBonafideReason] = useState('');
  const [lcReason, setLcReason] = useState('');
  const [bonafideRequests, setBonafideRequests] = useState([]);
  const [lcRequests, setLcRequests] = useState([]);
  const [activeLcClearances, setActiveLcClearances] = useState({});
  const [actionMessage, setActionMessage] = useState('');

  const API_BASE = 'http://localhost:8080';

  useEffect(() => {
    fetchStudentData();
  }, []);

  const fetchStudentData = async () => {
    try {
      const prn = user.prnno || '202213149';
      
      let bRes;
      try {
        bRes = await fetch(`${API_BASE}/api/v1/bonafide/student/${prn}`);
      } catch (err) {
        bRes = await fetch(`/api/v1/bonafide/student/${prn}`);
      }
      if (bRes && bRes.ok) {
        const bData = await bRes.json();
        setBonafideRequests(bData);
      }

      let lcRes;
      try {
        lcRes = await fetch(`${API_BASE}/api/v1/lc/student/${prn}`);
      } catch (err) {
        lcRes = await fetch(`/api/v1/lc/student/${prn}`);
      }
      if (lcRes && lcRes.ok) {
        const lcData = await lcRes.json();
        setLcRequests(lcData);

        for (const req of lcData) {
          try {
            const clRes = await fetch(`${API_BASE}/api/v1/lc/clearances/${req.id}`);
            if (clRes.ok) {
              const clData = await clRes.json();
              setActiveLcClearances(prev => ({ ...prev, [req.id]: clData }));
            }
          } catch (e) {
            console.error(e);
          }
        }
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handleApplyBonafide = async (e) => {
    e.preventDefault();
    if (!bonafideReason) return;
    try {
      let res;
      const payload = { prnno: user.prnno || 202213149, reason: bonafideReason };
      try {
        res = await fetch(`${API_BASE}/api/v1/bonafide/apply`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      } catch (err) {
        res = await fetch('/api/v1/bonafide/apply', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      }
      const data = await res.json();
      if (data.success) {
        setActionMessage('Bonafide Certificate request submitted to Student Desk!');
        setBonafideReason('');
        fetchStudentData();
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handleApplyLc = async (e) => {
    e.preventDefault();
    if (!lcReason) return;
    try {
      let res;
      const payload = { prnno: user.prnno || 202213149, reason: lcReason };
      try {
        res = await fetch(`${API_BASE}/api/v1/lc/apply`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      } catch (err) {
        res = await fetch('/api/v1/lc/apply', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      }
      const data = await res.json();
      if (data.success) {
        setActionMessage('Leaving Certificate request initiated across 12 Desks!');
        setLcReason('');
        fetchStudentData();
      }
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <div style={{ minHeight: '100vh', background: '#f1f5f9', color: '#1e293b', fontFamily: 'Arial, sans-serif' }}>
      
      {/* KEYSTONE BLUE HEADER BANNER */}
      <header style={{ background: '#0056b3', color: '#ffffff', padding: '0.85rem 2rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center', boxShadow: '0 2px 8px rgba(0,0,0,0.15)' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
          <div style={{ background: '#ffffff', borderRadius: '50%', width: '48px', height: '48px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 'bold', color: '#0056b3', fontSize: '20px', border: '2px solid #ffffff' }}>
            🎓
          </div>
          <div>
            <h1 style={{ fontSize: '1.4rem', fontWeight: '700', margin: 0 }}>Keystone School of Engineering</h1>
            <p style={{ fontSize: '0.8rem', color: '#e2e8f0', margin: 0 }}>Excellence in Technical Education Since 2012</p>
          </div>
        </div>

        <button 
          onClick={onLogout} 
          style={{ background: 'transparent', color: '#ffffff', border: '1px solid rgba(255,255,255,0.7)', padding: '0.4rem 1.2rem', borderRadius: '9999px', cursor: 'pointer', fontWeight: '600', fontSize: '0.85rem' }}
        >
          Logout 🚪
        </button>
      </header>

      <main style={{ maxWidth: '1100px', margin: '2rem auto', padding: '0 1rem' }}>

        <div style={{ background: '#ffffff', padding: '1.5rem', borderRadius: '12px', marginBottom: '2rem', border: '1px solid #e2e8f0', boxShadow: '0 2px 10px rgba(0,0,0,0.04)' }}>
          <h2 style={{ fontSize: '1.4rem', fontWeight: '700', margin: 0, color: '#0f172a' }}>
            Welcome, {user.studname || user.username || 'Vishal Shriram Ghuge'}!
          </h2>
          <p style={{ margin: '0.4rem 0 0 0', color: '#64748b' }}>
            PRN: <strong>{user.prnno || '202213149'}</strong> | Branch: <strong>{user.branch || 'Computer Engineering'}</strong>
          </p>
        </div>

        {actionMessage && (
          <div style={{ padding: '0.85rem 1.25rem', background: '#dcfce7', border: '1px solid #86efac', color: '#166534', borderRadius: '8px', marginBottom: '1.5rem', fontWeight: '600' }}>
            {actionMessage}
          </div>
        )}

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(450px, 1fr))', gap: '2rem' }}>
          
          {/* 1. Apply for Certificates Card */}
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '1.75rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)' }}>
            <h3 style={{ color: '#0056b3', fontSize: '1.2rem', marginBottom: '1.25rem', fontWeight: '700' }}>
              📝 Apply for Certificates
            </h3>

            {/* Bonafide Form */}
            <form onSubmit={handleApplyBonafide} style={{ marginBottom: '2rem' }}>
              <h4 style={{ fontSize: '0.95rem', fontWeight: '700', marginBottom: '0.5rem' }}>1. Bonafide Certificate</h4>
              <input 
                type="text"
                placeholder="Reason (e.g. Bus Pass Concession & Bank Loan)"
                value={bonafideReason}
                onChange={e => setBonafideReason(e.target.value)}
                style={{ width: '100%', padding: '0.75rem', border: '1px solid #cbd5e1', borderRadius: '6px', marginBottom: '0.75rem' }}
                required
              />
              <button type="submit" style={{ background: '#22c55e', color: 'white', border: 'none', padding: '0.6rem 1.25rem', borderRadius: '6px', cursor: 'pointer', fontWeight: '700' }}>
                Apply for Bonafide
              </button>
            </form>

            <hr style={{ border: 'none', borderTop: '1px solid #e2e8f0', margin: '1.5rem 0' }} />

            {/* LC Form */}
            <form onSubmit={handleApplyLc}>
              <h4 style={{ fontSize: '0.95rem', fontWeight: '700', marginBottom: '0.5rem' }}>2. Leaving Certificate (12-Desk Clearance)</h4>
              <input 
                type="text"
                placeholder="Reason (e.g. Migration Certificate / Higher Studies)"
                value={lcReason}
                onChange={e => setLcReason(e.target.value)}
                style={{ width: '100%', padding: '0.75rem', border: '1px solid #cbd5e1', borderRadius: '6px', marginBottom: '0.75rem' }}
                required
              />
              <button type="submit" style={{ background: '#f97316', color: 'white', border: 'none', padding: '0.6rem 1.25rem', borderRadius: '6px', cursor: 'pointer', fontWeight: '700' }}>
                Initiate 12-Desk LC Clearance
              </button>
            </form>
          </div>

          {/* 2. Track Request Status Card */}
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '1.75rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)' }}>
            <h3 style={{ color: '#0056b3', fontSize: '1.2rem', marginBottom: '1.25rem', fontWeight: '700' }}>
              📜 Application Status
            </h3>

            {/* Bonafide Status */}
            <h4 style={{ fontSize: '0.95rem', fontWeight: '700', marginBottom: '0.75rem' }}>Bonafide Applications</h4>
            {bonafideRequests.length === 0 ? (
              <p style={{ color: '#64748b', fontSize: '0.9rem' }}>No active Bonafide requests.</p>
            ) : (
              bonafideRequests.map(r => (
                <div key={r.id} style={{ background: '#f8fafc', padding: '0.85rem', borderRadius: '8px', marginBottom: '0.75rem', border: '1px solid #e2e8f0' }}>
                  <div style={{ fontWeight: 'bold' }}>{r.reason}</div>
                  <div style={{ fontSize: '0.85rem', color: '#64748b' }}>Status: <span style={{ color: '#f59e0b', fontWeight: 'bold' }}>{r.status}</span></div>
                </div>
              ))
            )}

            <hr style={{ border: 'none', borderTop: '1px solid #e2e8f0', margin: '1.5rem 0' }} />

            {/* LC Status */}
            <h4 style={{ fontSize: '0.95rem', fontWeight: '700', marginBottom: '0.75rem' }}>Leaving Certificate Applications</h4>
            {lcRequests.length === 0 ? (
              <p style={{ color: '#64748b', fontSize: '0.9rem' }}>No active Leaving Certificate requests.</p>
            ) : (
              lcRequests.map(r => (
                <div key={r.id} style={{ background: '#f8fafc', padding: '1rem', borderRadius: '8px', marginBottom: '0.75rem', border: '1px solid #e2e8f0' }}>
                  <div style={{ fontWeight: 'bold', color: '#0f172a' }}>{r.reason}</div>
                  <div style={{ fontSize: '0.85rem', marginTop: '0.3rem', color: '#475569' }}>
                    Current Progress: <strong>Desk {r.currentSection || 1} of 12</strong> ({r.status})
                  </div>
                </div>
              ))
            )}
          </div>

        </div>

      </main>
    </div>
  );
}
