import pygame
import random

# Initialize Pygame
pygame.init()

# Screen dimensions
SCREEN_WIDTH = 300
SCREEN_HEIGHT = 600
BLOCK_SIZE = 30
GRID_WIDTH = SCREEN_WIDTH // BLOCK_SIZE
GRID_HEIGHT = SCREEN_HEIGHT // BLOCK_SIZE

# Colors
WHITE = (255, 255, 255)
GRAY = (128, 128, 128)
BLACK = (0, 0, 0)
RED = (255, 0, 0)
GREEN = (0, 255, 0)
BLUE = (0, 0, 255)
YELLOW = (255, 255, 0)

# Tetromino shapes
SHAPES = [
    [[1, 1, 1, 1]],                     # I shape
    [[1, 1], [1, 1]],                   # O shape
    [[0, 1, 0], [1, 1, 1]],             # T shape
    [[1, 1, 0], [0, 1, 1]],             # S shape
    [[0, 1, 1], [1, 1, 0]],             # Z shape
    [[1, 1, 1], [1, 0, 0]],             # L shape
    [[1, 1, 1], [0, 0, 1]],             # J shape
]

# Class to represent a tetromino
class Tetromino:
    def __init__(self, shape, color):
        self.shape = shape
        self.color = color
        self.x = GRID_WIDTH // 2 - len(self.shape[0]) // 2
        self.y = 0

    def rotate(self):
        self.shape = [list(row) for row in zip(*self.shape[::-1])]

# Create a grid
def create_grid(locked_positions={}):
    grid = [[BLACK for _ in range(GRID_WIDTH)] for _ in range(GRID_HEIGHT)]
    for (x, y), color in locked_positions.items():
        grid[y][x] = color
    return grid

# Draw the grid
def draw_grid(surface, grid):
    for y in range(GRID_HEIGHT):
        for x in range(GRID_WIDTH):
            pygame.draw.rect(surface, grid[y][x], (x * BLOCK_SIZE, y * BLOCK_SIZE, BLOCK_SIZE, BLOCK_SIZE), 0)
    for x in range(GRID_WIDTH):
        pygame.draw.line(surface, GRAY, (x * BLOCK_SIZE, 0), (x * BLOCK_SIZE, SCREEN_HEIGHT))
    for y in range(GRID_HEIGHT):
        pygame.draw.line(surface, GRAY, (0, y * BLOCK_SIZE), (SCREEN_WIDTH, y * BLOCK_SIZE))

# Draw the tetromino
def draw_tetromino(surface, tetromino):
    for y, row in enumerate(tetromino.shape):
        for x, cell in enumerate(row):
            if cell:
                pygame.draw.rect(surface, tetromino.color, 
                                 ((tetromino.x + x) * BLOCK_SIZE, 
                                  (tetromino.y + y) * BLOCK_SIZE, 
                                  BLOCK_SIZE, BLOCK_SIZE), 0)

# Draw the window
def draw_window(surface, grid, current_piece):
    surface.fill(BLACK)
    draw_grid(surface, grid)
    draw_tetromino(surface, current_piece)  # Draw the current piece
    pygame.display.update()

# Check if position is valid
def valid_space(tetromino, grid):
    for y, row in enumerate(tetromino.shape):
        for x, cell in enumerate(row):
            if cell:
                if (y + tetromino.y >= GRID_HEIGHT or 
                    x + tetromino.x < 0 or 
                    x + tetromino.x >= GRID_WIDTH or 
                    grid[y + tetromino.y][x + tetromino.x] != BLACK):
                    return False
    return True

# Check for line clear
def clear_lines(grid, locked_positions):
    lines_cleared = 1
    for y in range(GRID_HEIGHT - 1, -1, -1):
        if BLACK not in grid[y]:  # Check if the line is full
            lines_cleared += 1
            del grid[y]
            grid.insert(0, [BLACK for _ in range(GRID_WIDTH)])  # Add new empty line at the top
            # Update locked positions
            for (x, y_locked) in list(locked_positions):
                if y_locked < y:  # Shift down if it's below the cleared line
                    locked_positions[(x, y_locked + 1)] = locked_positions.pop((x, y_locked))
    return lines_cleared

# Main game loop
def main():
    locked_positions = {}
    grid = create_grid(locked_positions)

    current_piece = Tetromino(random.choice(SHAPES), random.choice([RED, GREEN, BLUE, YELLOW]))
    next_piece = Tetromino(random.choice(SHAPES), random.choice([RED, GREEN, BLUE, YELLOW]))

    clock = pygame.time.Clock()
    fall_time = 0
    fall_speed = 0.3
    running = True
    score = 0

    screen = pygame.display.set_mode((SCREEN_WIDTH, SCREEN_HEIGHT))
    pygame.display.set_caption('Tetris')

    while running:
        grid = create_grid(locked_positions)
        fall_time += clock.get_rawtime()
        clock.tick()

        # Move tetromino down every interval
        if fall_time / 1000 >= fall_speed:
            current_piece.y += 1
            if not valid_space(current_piece, grid):
                current_piece.y -= 1  # Move back up
                # Lock the piece
                for y, row in enumerate(current_piece.shape):
                    for x, cell in enumerate(row):
                        if cell:
                            locked_positions[(x + current_piece.x, y + current_piece.y)] = current_piece.color
                # Clear lines immediately after locking the piece
                score += clear_lines(grid, locked_positions) * 10
                current_piece = next_piece
                next_piece = Tetromino(random.choice(SHAPES), random.choice([RED, GREEN, BLUE, YELLOW]))
            fall_time = 0

        # Event handling
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                running = False
            if event.type == pygame.KEYDOWN:
                if event.key == pygame.K_LEFT:
                    current_piece.x -= 1
                    if not valid_space(current_piece, grid):
                        current_piece.x += 1
                if event.key == pygame.K_RIGHT:
                    current_piece.x += 1
                    if not valid_space(current_piece, grid):
                        current_piece.x -= 1
                if event.key == pygame.K_DOWN:
                    current_piece.y += 1
                    if not valid_space(current_piece, grid):
                        current_piece.y -= 1
                if event.key == pygame.K_UP:
                    current_piece.rotate()
                    if not valid_space(current_piece, grid):
                        current_piece.rotate()
                        current_piece.rotate()
                        current_piece.rotate()

        # Check if tetromino has reached the top
        if any(y < 1 for (x, y) in locked_positions):
            print("Game Over")
            running = False

        # Draw the window
        draw_window(screen, grid, current_piece)

    pygame.quit()

if __name__ == "__main__":
    main()
