const elements = document.querySelectorAll('.artist-card');
const rotations = ['rotate-minus-15', 'rotate-minus-10', 'rotate-minus-5', 'rotate-5', 'rotate-10', 'rotate-15'];

elements.forEach(element => {
    const randomIndex = Math.floor(Math.random() * rotations.length);
    const randomRotation = rotations[randomIndex];
    element.classList.add(randomRotation);
});