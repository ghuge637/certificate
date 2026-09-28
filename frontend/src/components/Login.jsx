import React, { useState } from 'react';

export default function Login({ onLoginSuccess }) {
  const [role, setRole] = useState('STUDENT');
  const [username, setUsername] = useState('student1');
  const [password, setPassword] = useState('password123');
  const [alert, setAlert] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setAlert(null);
    setLoading(true);

    const loginData = { username, password, role };

    try {
      // Try local proxied endpoint or direct Spring Boot port 8080
      let res;
      try {
        res = await fetch('/api/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(loginData)
        });
      } catch (proxyErr) {
        // Fallback to direct backend URL
        res = await fetch('http://localhost:8080/api/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(loginData)
        });
      }

      const data = await res.json();
      if (data.success) {
        setAlert({ type: 'success', message: 'Authentication successful! Redirecting...' });
        setTimeout(() => {
          onLoginSuccess(data.user);
        }, 600);
      } else {
        setAlert({ type: 'danger', message: data.message });
      }
    } catch (err) {
      setAlert({
        type: 'danger',
        message: 'Unable to connect to Spring Boot backend at http://localhost:8080. Please start your Spring Boot server in Eclipse!'
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh', padding: '1rem' }}>
      <div className="glass-card" style={{ width: '100%', maxWidth: '440px', padding: '2.5rem' }}>
        <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
          <div style={{ fontSize: '2.5rem', marginBottom: '0.5rem' }}>🎓</div>
          <h1 style={{ fontSize: '1.5rem', fontWeight: '800' }}>Certificate Portal</h1>
          <p style={{ color: 'var(--text-muted)', fontSize: '0.875rem', marginTop: '0.25rem' }}>Enterprise React JS System</p>
        </div>

        <div style={{ display: 'flex', background: 'rgba(15, 23, 42, 0.6)', padding: '4px', borderRadius: '12px', marginBottom: '1.75rem', border: '1px solid var(--border-color)' }}>
          <button
            type="button"
            className="gradient-btn"
            style={{ flex: 1, padding: '0.65rem', background: role === 'STUDENT' ? undefined : 'transparent', color: role === 'STUDENT' ? '#fff' : 'var(--text-muted)' }}
            onClick={() => { setRole('STUDENT'); setUsername('student1'); }}
          >
            👨‍🎓 Student
          </button>
          <button
            type="button"
            className="gradient-btn"
            style={{ flex: 1, padding: '0.65rem', background: role === 'STAFF' ? undefined : 'transparent', color: role === 'STAFF' ? '#fff' : 'var(--text-muted)' }}
            onClick={() => { setRole('STAFF'); setUsername('staff_stud'); }}
          >
            👨‍🏫 Staff / Admin
          </button>
        </div>

        {alert && (
          <div style={{ padding: '0.75rem 1rem', borderRadius: '8px', marginBottom: '1.25rem', background: alert.type === 'success' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)', border: `1px solid ${alert.type === 'success' ? 'rgba(34, 197, 94, 0.4)' : 'rgba(239, 68, 68, 0.4)'}`, color: alert.type === 'success' ? '#86efac' : '#fca5a5', fontSize: '0.875rem' }}>
            {alert.message}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div style={{ marginBottom: '1.25rem' }}>
            <label style={{ display: 'block', fontSize: '0.8rem', fontWeight: 600, color: 'var(--text-muted)', marginBottom: '0.5rem', textTransform: 'uppercase' }}>
              {role === 'STUDENT' ? 'PRN Number / Username' : 'Staff Username'}
            </label>
            <input
              type="text"
              className="input-field"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>

          <div style={{ marginBottom: '1.5rem' }}>
            <label style={{ display: 'block', fontSize: '0.8rem', fontWeight: 600, color: 'var(--text-muted)', marginBottom: '0.5rem', textTransform: 'uppercase' }}>
              Password
            </label>
            <input
              type="password"
              className="input-field"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>

          <button type="submit" className="gradient-btn" style={{ width: '100%', padding: '0.9rem', fontSize: '1rem' }} disabled={loading}>
            {loading ? 'Authenticating...' : `Log In as ${role === 'STUDENT' ? 'Student' : 'Staff'}`}
          </button>
        </form>

        <div style={{ marginTop: '1.75rem', padding: '1rem', background: 'rgba(15, 23, 42, 0.5)', borderRadius: '10px', border: '1px dashed var(--border-color)', fontSize: '0.8rem', color: 'var(--text-muted)' }}>
          <strong>📌 Demo Credentials:</strong><br />
          • Student: <code>student1</code> (PRN: <code>202213149</code>) / <code>password123</code><br />
          • Staff: <code>staff_stud</code> / <code>password123</code>
        </div>
      </div>
    </div>
  );
}
