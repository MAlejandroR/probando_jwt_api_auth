import logo from './logo.svg';
import './App.css';
import React, {useState, useEffect} from "react";

function App() {
    const [token, setToken] = useState(null);
    const [userData, setUserData] = useState(null);
    useEffect(() => {
        // Simula la autenticación y obtención del token
        const obtenerToken = async () => {
            try {
                const response = await fetch('http://localhost:8080', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',

                    },
                    body: JSON.stringify({
                        usuario: 'maria',
                        password: 'maria',
                    }),
                });
                const data = await response.json();
                if (data.token) {
                    console.log("Te has autenticado");
                    setToken(data.token);

                }
            } catch (error) {
                console.log("Error al obtener el tocken", error);
            }

        };
        obtenerToken();
    }, []);
    // useEffect(() => {
    //     // Si tienes un token, realiza una solicitud protegida
    //     if (token) {
    //         const obtenerDatosProtegidos = async () => {
    //             try {
    //                 const response = await fetch('http://localhost:8080', {
    //                     headers: {
    //                         Authorization: `Bearer ${token}`,
    //                     },
    //                 });
    //
    //                 const data = await response.json();
    //                 setUserData(data);
    //             } catch (error) {
    //                 console.log('Error al obtener datos protegidos:', error);
    //             }
    //         };
    //
    //         obtenerDatosProtegidos();
    //     }
    // }, [token]);


    return   (
        <div>
            <h1>Aplicación React con Autenticación JWT</h1>
            {token ? (
                <div>
                    <p>Token JWT: {token}</p>
                    {userData && (
                        <div>
                            <h2>Datos protegidos:</h2>
                            <pre>{JSON.stringify(userData, null, 2)}</pre>
                        </div>
                    )}
                </div>
            ) : (
                <p>Obteniendo token...</p>
            )}
        </div>
    );
}

export default App;