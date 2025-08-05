import React from 'react';
import './salesGraph.css';

const SalesGraph = ({ title, data = [] }) => {
  if (!data.length) return <div>Loading graph...</div>;

  const width = 400;
  const height = 200;
  const padding = 40;

  const cleanedData = data.map(d => ({
    ...d,
    total: parseFloat(d.total)
  }));

  const maxTotal = Math.max(...cleanedData.map(d => d.total));
  const minTotal = 0; 
  const yTicks = 4;
  const yStep = (maxTotal - minTotal) / yTicks;

  if (cleanedData.length === 1) {
    const x = width / 2;
    const y = height - padding - ((cleanedData[0].total / maxTotal) * (height - 2 * padding));

    return (
      <div className="sales-graph">
        <h3>{title || 'Sales Graph'}</h3>
        <svg width={width} height={height} className="graph-svg">
          {/* Axes */}
          <line x1={padding} y1={padding} x2={padding} y2={height - padding} stroke="#ccc" />
          <line x1={padding} y1={height - padding} x2={width - padding} y2={height - padding} stroke="#ccc" />

          {/* Single dot */}
          <circle cx={x} cy={y} r="4" fill="#5A67D8" />
          <text x={x} y={y - 10} textAnchor="middle" fontSize="12">
            ${cleanedData[0].total}
          </text>
        </svg>
      </div>
    );
  }

  // Multiple points
  const points = cleanedData.map((d, i) => {
    const x = padding + ((width - 2 * padding) / (cleanedData.length - 1)) * i;
    const y = height - padding - ((d.total - minTotal) / (maxTotal - minTotal)) * (height - 2 * padding);
    return { x, y, label: d.date };
  });

  const pathData = points.reduce((acc, point, i) => {
    return acc + (i === 0 ? `M ${point.x},${point.y}` : ` L ${point.x},${point.y}`);
  }, '');

  return (
    <div className="sales-graph">
      <h3>{title || 'Sales Graph'}</h3>
      <svg width={width} height={height} className="graph-svg">
        {[...Array(yTicks + 1)].map((_, i) => {
          const yVal = minTotal + i * yStep;
          const y = height - padding - (i / yTicks) * (height - 2 * padding);
          return (
            <g key={i}>
              <line x1={padding} y1={y} x2={width - padding} y2={y} stroke="#eee" strokeDasharray="2" />
              <text x={padding - 10} y={y + 4} fontSize="10" textAnchor="end">
                ${yVal.toFixed(0)}
              </text>
            </g>
          );
        })}

        {points.map((p, i) => (
          <g key={i}>
            <line x1={p.x} y1={height - padding} x2={p.x} y2={height - padding + 5} stroke="#aaa" />
            <text x={p.x} y={height - padding + 15} fontSize="10" textAnchor="middle">
              {p.label.slice(5)} 
            </text>
          </g>
        ))}

        <line x1={padding} y1={padding} x2={padding} y2={height - padding} stroke="#aaa" />
        <line x1={padding} y1={height - padding} x2={width - padding} y2={height - padding} stroke="#aaa" />

        <path d={pathData} fill="none" stroke="#5A67D8" strokeWidth="2" />

        {points.map((p, i) => (
          <circle key={i} cx={p.x} cy={p.y} r="3" fill="#5A67D8" />
        ))}
      </svg>
    </div>
  );
};

export default SalesGraph;
