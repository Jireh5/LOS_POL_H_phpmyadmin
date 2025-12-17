
  // --- 9. LEAFLET MAP LOGIC ---
  if(document.getElementById('map')) {
    
    const southWest = L.latLng(31.0, -120.0); 
    const northEast = L.latLng(37.0, -103.0); 
    const bounds = L.latLngBounds(southWest, northEast);

    const map = L.map('map', {
      center: [34.5, -111.5], 
      zoom: 6,
      minZoom: 6,             
      maxBounds: bounds,      
      maxBoundsViscosity: 1.0 
    });

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'Tiles &copy; Esri'
    }).addTo(map);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}').addTo(map);

    const goldIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

    const stores = [
      {
        name: "Albuquerque (HQ)",
        coords: [35.0844, -106.6504],
        manager: "G. Fring",
        hours: "10:00 AM – 10:00 PM"
      },
      {
        name: "Los Angeles Distribution",
        coords: [34.0522, -118.2437],
        manager: "A. Ortega",
        hours: "9:00 AM – 11:00 PM"
      }
    ];

    stores.forEach(store => {
      const marker = L.marker(store.coords, { icon: goldIcon }).addTo(map);

      const popupContent = `
        <div style="text-align:center; 
        font-family: 'Helvetica Neue', sans-serif;">
        <h3 style="margin:0 0 5px 0; 
        font-size:0.8rem; 
        color:#e6a00f;">
        ${store.name}</h3>
        <p style="margin:0; 
        font-size:0.7rem;">
        <strong>Manager:</strong> 
        ${store.manager}</p>
        <p style="margin:0; 
        font-size:0.7rem;">
        <strong>Hours:</strong> 
        ${store.hours}</p>
        </div>
      `;

      marker.bindPopup(popupContent);

      marker.on('mouseover', function (e) {
        this.openPopup();
      });
      marker.on('mouseout', function (e) {
        this.closePopup();
      });
    });

    window.focusStore = function(lat, lng) {
      map.flyTo([lat, lng], 10, {
        animate: true,
        duration: 1.5
      });
    };
  }


