const express = import('express');
const fetch = import('node-fetch');
const app = (await express)();
const PORT = 3000;

app.use(express.json());

app.get('/directions', async (req, res) => {
    const { origin, destination, apiKey } = req.query;
    const url = `https://maps.googleapis.com/maps/api/directions/json?origin=${origin}&destination=${destination}&key=${apiKey}`;
    try {
        const response = await fetch(url);
        const data = await response.json();
        res.json(data);
    } catch (error) {
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
