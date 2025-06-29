import React, { useEffect, useState } from 'react';
import './../../../css/LoginWidget.css';

const LoginWidget = () => {
    const [itemCount, setItemCount] = useState(null); // State pentru a ține numărul de elemente
    const [loading, setLoading] = useState(false); // State pentru a gestiona încărcarea
    const [filter, setFilter] = useState(''); // State pentru a ține filtrul curent
    const [data, setData] = useState([]); // State pentru a ține datele brute

    // @ts-ignore
    const fetchData = async () => {
        setLoading(true); // Setează loading la true înainte de a începe requestul
        try {
            const response = await fetch('http://localhost/api/login-statistics'); // Înlocuiește cu endpoint-ul tău
            const data = await response.json();
            setData(data); // Stochează datele brute
            applyFilter(filter, data); // Aplică filtrul curent pe datele brute
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            setLoading(false); // Setează loading la false după finalizarea apelului
        }
    };

    const applyFilter = (filterType, data) => {
        const now = new Date();
        const filteredData = data.filter(item => {
            const loginDate = new Date(item.login_time);
            switch (filterType) {
                case 'Year':
                    return loginDate.getFullYear() === now.getFullYear();
                case 'Month':
                    return loginDate.getFullYear() === now.getFullYear() && loginDate.getMonth() === now.getMonth();
                case 'Week':
                    const startOfWeek = new Date(now.setDate(now.getDate() - now.getDay())); // Începutul săptămânii curente
                    // @ts-ignore
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6); // Sfârșitul săptămânii curente
                    return loginDate >= startOfWeek && loginDate <= endOfWeek;
                case 'Day':
                    return loginDate.toDateString() === now.toDateString();
                default:
                    return true;
            }
        });
        setItemCount(filteredData.length);
    };

    useEffect(() => {
        fetchData(); // Apelăm fetchData la montarea componentului

        // Polling pentru a verifica datele la fiecare 5 secunde
        const intervalId = setInterval(() => {
            fetchData();
        }, 10000); // Interval de 5 secunde

        // Cleanup la demontarea componentului
        return () => clearInterval(intervalId);
    }, []);

    useEffect(() => {
        if (!loading) {
            const filterButtons = document.querySelectorAll('.filter-button');
            filterButtons.forEach(button => button.classList.remove('hover'));
        }
    }, [loading]);

    return (
        <div className="login-widget">
            <div className="left-section">
                <div className="title">
                    <img src="https://img.icons8.com/?size=100&id=p2yO8QtJYrz8&format=png&color=000000" alt="Icon" className="icon" />
                    <h2>Users Login</h2>
                </div>
                <div className="filters">
                    <button
                        className={`filter-button ${filter === 'Year' ? 'active hover' : ''} ${loading ? 'disabled' : ''}`}
                        onClick={() => { setFilter('Year'); applyFilter('Year', data); }}
                        disabled={loading} // Dezactivează butonul în timp ce se face requestul
                    >
                        Year
                    </button>
                    <button
                        className={`filter-button ${filter === 'Month' ? 'active hover' : ''} ${loading ? 'disabled' : ''}`}
                        onClick={() => { setFilter('Month'); applyFilter('Month', data); }}
                        disabled={loading} // Dezactivează butonul în timp ce se face requestul
                    >
                        Month
                    </button>
                    <button
                        className={`filter-button ${filter === 'Week' ? 'active hover' : ''} ${loading ? 'disabled' : ''}`}
                        onClick={() => { setFilter('Week'); applyFilter('Week', data); }}
                        disabled={loading} // Dezactivează butonul în timp ce se face requestul
                    >
                        Week
                    </button>
                    <button
                        className={`filter-button ${filter === 'Day' ? 'active hover' : ''} ${loading ? 'disabled' : ''}`}
                        onClick={() => { setFilter('Day'); applyFilter('Day', data); }}
                        disabled={loading} // Dezactivează butonul în timp ce se face requestul
                    >
                        Day
                    </button>
                </div>
                <div className="date">
                    {filter}
                </div>
            </div>
            <div className="right-section">
                {loading ? <span className="number">Loading...</span> : <span className="number">{itemCount}</span>}
            </div>
        </div>
    );
};

export default LoginWidget;
